<?php
declare(strict_types=1);
require __DIR__.'/../common/security.php';
require __DIR__.'/../common/db.php';
ensure_session();

/**
 * ここでは学習用に「ページング + プリペアド + JOIN + ORDER + LIMIT/OFFSET」を
 * 自分で実装してもらう骨組みにしています。
 *
 * 【実装要件（MUST）】
 * - GET ?page=N を受け取り、1未満は1に丸める
 * - 1ページ20件、最新注文（order_date DESC, id DESC）の順
 * - users と JOIN して、o.id, u.name AS user_name, o.order_date, o.total_amount を取得
 * - 「次のページがあるか」を判定するために (perPage+1) 件取得し、超過分は捨てる
 * - プリペアド + バインド（:limit, :offset は INT で）
 * - 文字列連結SQLは禁止
 */

// ---------- STEP 1: ページ番号の取得（TODO） ----------
$perPage = 20;
// $page = max(1, (int)($_GET['page'] ?? 1)); // ← 例
$page = max(1, (int)($_GET['page']?? 1)); // TODO: 上の例のように GET から取得して1未満は1に

// ---------- STEP 2: OFFSET の計算（TODO） ----------
$offset = ($page - 1) * $perPage; // TODO: ($page - 1) * $perPage を代入

// ---------- STEP 3: SQL を組み立て（TODO） ----------
// 要件：orders と users を JOIN、order_date DESC, id DESC、LIMIT/OFFSET
$fetchLimit = $perPage + 1;

$sql = <<<SQL
SELECT o.id,
       u.name AS user_name,
       o.order_date,
       o.total_amount
FROM   orders o
JOIN   users u ON u.id = o.user_id
ORDER BY o.order_date DESC, o.id DESC
LIMIT :limit OFFSET :offset
SQL;
$rows    = [];
$hasNext = false;
$hasPrev = $page > 1;

try {
  $st = pdo()->prepare($sql);
  $st->bindValue(':limit', $fetchLimit, PDO::PARAM_INT);
  $st->bindValue(':offset', $offset, PDO::PARAM_INT);
  $st->execute();
  $rows = $st->fetchAll();

  if (count($rows) > $perPage) {
    $hasNext = true;
    array_pop($rows);
  }
} catch (Throwable $e) {
  error_log('[orders/index]' . $e->getMessage());
}
?>
<!doctype html>
<html lang="ja">
<meta charset="utf-8">
<?= csp_meta() ?>
<link rel="stylesheet" href="../assets/styles.css">
<title>注文一覧</title>
<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <h1>注文一覧</h1>
        <span class="badge"><?= htmlspecialchars((string)$perPage, ENT_QUOTES, 'UTF-8') ?>件/ページ</span>
      </div>
      <div class="button-row">
        <a href="new.php"><button>新規注文</button></a>
      </div>
    </div>
    <div class="card">
      <table>
        <thead>
          <tr>
            <th>ID</th><th>ユーザー</th><th>注文日</th>
            <th style="text-align:right;">合計</th><th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= e((string)($r['id'] ?? '')) ?></td>
              <td><?= e((string)($r['user_name'] ?? '')) ?></td>
              <td><?= e((string)($r['order_date'] ?? '')) ?></td>
              <td style="text-align:right;">¥<?= number_format((float)($r['total_amount'] ?? 0)) ?></td>
              <td><a href="show.php?id=<?= e((string)($r['id'] ?? '')) ?>">詳細</a></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?>
            <tr><td colspan="5" class="small">データがありません。（SQL & バインド & フェッチを実装して表示させてください）</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="pagination">
        <a class="<?= $hasPrev ? '' : 'disabled' ?>" href="?page=<?= e((string)max(1, $page - 1)) ?>">« 前</a>
        <a class="<?= $hasNext ? '' : 'disabled' ?>" href="?page=<?= e((string)($page + 1)) ?>">次 »</a>
      </div>
    </div>
  </div>
</body>
</html>