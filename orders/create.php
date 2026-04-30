<?php
declare(strict_types=1);
require __DIR__.'/../common/security.php';
require __DIR__.'/../common/db.php';
ensure_session();

/**
 * 下の TODO を埋めて、正常動作させてください。
 */

// ---------- STEP 0: メソッド制御 ----------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

// ---------- STEP 1: CSRF チェック（TODO） ----------
// ヒント: security.php の verify_csrf() を使う
// if ( ... ) { http_response_code(400); exit('Bad Request (CSRF)'); }
if (!verify_csrf($_POST['csrf_token'] ?? null)) {
  http_response_code(400);
  exit('Bad Request (CSRF)');
}

// ---------- STEP 2: 入力取得とバリデーション（TODO） ----------
$errors = [];
$user_id = (string)($_POST['user_id'] ?? '');
$qtyPost = $_POST['qty'] ?? [];               // qty は ["product_id" => "数量"] の配列で飛んでくる
$qtys    = is_array($qtyPost) ? $qtyPost : []; // 異常系に備え防御的に

// 2-1) users テーブルに user_id が存在するか確認（PDOでSELECT）
if ($user_id === '') {
  $errors[] = 'ユーザーを選択してください。';
} else {
  $st = pdo()->prepare('SELECT id FROM users WHERE id = :id');
  $st->execute([':id' => $user_id]);
  if (!$st->fetch()) {
    $errors[] = '選択されたユーザーが存在しません。';
  }
}
// 2-2) 数量の検証：整数・0〜99のみ許可、1つ以上が1以上であること
$selected = []; // [ product_id(int) => qty(int) ]
foreach ($qtys as $pid_raw => $qty_raw) {
  $pid = filter_var($pid_raw, FILTER_VALIDATE_INT);
  $qty = filter_var($qty_raw, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 0, 'max_range' => 99],
  ]);
  if ($pid === false) {
    $errors[] = '不正な商品IDが含まれています。';
    continue;
  }
  if ($qty === false) {
    $errors[] = "商品ID {$pid} の数量が不正です（0〜99の整数を入力してください）。";
    continue;
  }
  if ($qty > 0) {
    $selected[(int)$pid] = $qty;
  }
}
if (empty($selected) && empty($errors)) {
  $errors[] = '少なくとも1商品を1個以上選択してください。';
}
// 上記チェックで NG の場合は $errors[] に日本語メッセージを積む

// ---------- バリデーションNG時の処理（完成済み） ----------
if ($errors) {
  flash_set('errors', $errors);
  flash_set('old', ['user_id' => $user_id, 'qty' => $qtys]);
  redirect_see_other('new.php');
}

// ---------- STEP 3: 単価を DB から取得（TODO） ----------
// ヒント：IN 句で該当 product_id 一覧を取得 → id, name, price を配列で受ける
// $products = [...];
$pids         = array_keys($selected);
$placeholders = implode(',', array_fill(0, count($pids), '?'));
$stProducts   = pdo()->prepare(
  "SELECT id, name, price FROM products WHERE id IN ({$placeholders})"
);
$stProducts->execute(array_values($pids));
$dbProducts = $stProducts->fetchAll();

if (count($dbProducts) !== count($pids)) {
  flash_set('errors', ['存在しない商品が選択されています。']);
  flash_set('old', ['user_id' => $user_id, 'qty' => $qtys]);
  redirect_see_other('new.php');
}
// 取得件数が $selected 件未満なら、存在しない商品IDが混じっている → エラーにして new.php へ

// ---------- STEP 4: 合計金額のサーバ計算（TODO） ----------
$total = 0.0;
$map   = []; // [ product_id => ['qty'=>..., 'unit_price'=>...] ]
foreach ($dbProducts as $p) {
  $pid          = (int)$p['id'];
  $unit_price   = (float)$p['price'];
  $qty          = $selected[$pid];
  $total       += $qty * $unit_price;
  $map[$pid]    = ['qty' => $qty, 'unit_price' => $unit_price];
}
// foreach ($products as $p) { ... } で $total と $map を作る

// ---------- STEP 5: 取引（トランザクション）で登録（TODO） ----------
// 5-1) beginTransaction()
// 5-2) orders に (user_id, order_date=今日, total_amount) を INSERT → lastInsertId() を取得
// 5-3) order_items に (order_id, product_id, qty, unit_price) を ループで INSERT
// 5-4) commit()
// 失敗時は catch(Throwable) で rollback() → ログ出力 → フラッシュして new.php に戻る
$order_id = null;
try {
  pdo()->beginTransaction();
  $stOrder = pdo()->prepare(
    'INSERT INTO orders (user_id, order_date, total_amount)
    VALUES (:user_id, CURDATE(), :total)'
  );
  $stOrder->execute([':user_id' => $user_id, ':total' => $total]);
  $order_id = (int)pdo()->lastInsertId();

  $stItem = pdo()->prepare(
    'INSERT INTO order_items (order_id, product_id, qty, unit_price)
    VALUES (:order_id, :product_id, :qty, :unit_price)'
  );
  foreach ($map as $pid => $item) {
    $stItem->execute([
      ':order_id'        => $order_id,
      ':product_id'      => $pid,
      ':qty'             => $item['qty'],
      ':unit_price'      => $item['unit_price'],
    ]);
  }
  pdo()->commit();

} catch (Throwable $e) {
  if (pdo()->inTransaction()) {
    pdo()->rollBack();
  }
  error_log('[orders/create]' . $e->getMessage());
  flash_set('errors',['注文の保存中にエラーが発生しました。']);
  flash_set('old', ['user_id' => $user_id, 'qty' => $qtys]);
  redirect_see_other('new.php');
}

// ---------- STEP 6: PRG（完成済み） ----------
redirect_see_other('show.php?id=' . $order_id);

// ここまで実装できたら、/orders/show.php?id=... で結果が見えるはずです。
