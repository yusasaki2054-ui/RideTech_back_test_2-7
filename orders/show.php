<?php
declare(strict_types=1);
require __DIR__.'/../common/security.php';
require __DIR__.'/../common/db.php';
ensure_session();

/**
 * 学習用に「ID検証 + プリペアド + JOIN 取得 + 404/500 ハンドリング」を
 * 自分で実装してもらう骨組みにしています。
 *
 * 【実装要件（MUST）】
 * - GET ?id= の正の整数のみ受け付け、1未満は 400 Bad Request
 * - orders と users を JOIN してヘッダ（id, order_date, total_amount, user_name）を取得
 * - order_items と products を JOIN して明細（product_name, qty, unit_price, qty*unit_price）を取得
 * - いずれもプリペアド + バインドで :id を使用（文字列連結SQL禁止）
 * - 注文が存在しない場合は 404 Not Found
 * - 出力は e() で必ずエスケープ
 */

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { http_response_code(400); exit('Bad Request'); }

$head = null;
$list = [];

try {
  // ---------- STEP 1: 注文ヘッダの取得（TODO） ----------
  $sqlHead = <<<SQL
    SELECT o.id,
           o.order_date,
           o.total_amount,
           u.name AS user_name
      FROM orders o
      JOIN users u ON u.id = o.user_id
      WHERE o.id = :id

-- TODO: SQLを組み立ててください
SQL;
$stHead = pdo()->prepare($sqlHead);
$stHead->execute([':id' => $id]);
$head = $stHead->fetch();

if (!$head) {
  http_response_code(404);
  exit('Not Found');
}
  // ここでSQLを実行してください

  // ---------- STEP 2: 明細の取得（TODO） ----------
  $sqlItems = <<<SQL
-- TODO:SQLを組み立ててください
    SELECT p.name
           AS product_name,
           oi.qty,
           oi.unit_price,
           (oi.qty * oi.unit_price) AS subtotal
      FROM order_items oi
      JOIN products p ON p.id = oi.product_id
      WHERE oi.order_id = :id
      ORDER BY oi.id ASC
SQL;
  // 例：
  // ここでSQLを実行してください
  $stItems = pdo()->prepare($sqlItems);
  $stItems->execute([':id' => $id]);
  $list = $stItems->fetchAll();

} catch (Throwable $e) {
  error_log('[orders/show] '.$e->getMessage());
  http_response_code(500);
  exit('Internal Server Error');
}
?>
<!doctype html>
<html lang="ja">
<meta charset="utf-8">
<?= csp_meta() ?>
<link rel="stylesheet" href="../assets/styles.css">
<title>注文詳細 #<?= e((string)$head['id']) ?></title>
<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <h1>注文 #<?= e((string)$head['id']) ?></h1>
        <span class="badge"><?= e((string)$head['order_date']) ?><?= $head['order_date'] && $head['user_name'] ? ' / ' : '' ?><?= e((string)$head['user_name']) ?></span>
      </div>
      <div class="button-row">
        <a href="new.php"><button class="secondary">新規注文</button></a>
        <a href="index.php"><button class="secondary">一覧へ</button></a>
      </div>
    </div>

    <div class="card">
      <h2>明細</h2>
      <table>
        <thead>
          <tr><th>商品名</th><th>数量</th><th style="text-align:right;">単価</th><th style="text-align:right;">小計</th></tr>
        </thead>
        <tbody>
          <?php foreach ($list as $it): ?>
            <tr>
              <td><?= e((string)($it['product_name'] ?? '')) ?></td>
              <td><?= e((string)($it['qty'] ?? '')) ?></td>
              <td style="text-align:right;">¥<?= number_format((float)($it['unit_price'] ?? 0)) ?></td>
              <td style="text-align:right;">¥<?= number_format((float)($it['subtotal'] ?? 0)) ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$list): ?>
            <tr><td colspan="4" class="small">明細が表示されていません（SQLを実装して取得してください）。</td></tr>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" style="text-align:right;">合計</th>
            <th style="text-align:right;">¥<?= number_format((float)($head['total_amount'] ?? 0)) ?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</body>
</html>