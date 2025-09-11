# 2-7-1 注文登録ミニアプリ（作成のみ）

このスケルトンから **CSRF 検証 / サーバ側バリデーション / 取引登録（orders + order_items） / PRG / 結果表示** を実装してください。  
**Bootstrap は使わず、自作 CSS（`assets/styles.css`）を利用**しています。

## 目標（MUST）

- `orders/new.php` のフォームから注文を作成できること
- `orders/create.php` で
  - [ ] CSRF トークンを `hash_equals` で検証
  - [ ] `user_id` の実在チェック
  - [ ] 数量は **整数・0〜99**、**少なくとも 1 つが 1 以上**
  - [ ] 単価は **DB の products.price を使用**（フォーム値を信用しない）
  - [ ] **トランザクション**で `orders` → `order_items[*]` を登録し **commit/rollback**
  - [ ] 成功時は **PRG(303)** で `show.php?id=...` へ
  - [ ] 失敗時は **エラー表示＋入力保持**（sticky）
- `orders/index.php` で注文一覧、`orders/show.php` で詳細が安全に表示されること
- 画面の **出力はすべてエスケープ**（`htmlspecialchars(..., ENT_QUOTES)`）

## 構成

```
.
├─ README.md
├─ .env
├─ assets/
│  └─ styles.css          # 自作CSS（編集可）
├─ common/
│  ├─ db.php              # PDO接続（そのまま使用）
│  └─ security.php        # CSRF/エスケープ/フラッシュ等のヘルパ（使用推奨）
└─ orders/
   ├─ index.php           # 一覧（完成済み）
   ├─ new.php             # フォーム（完成済み）
   ├─ create.php          # ★実装課題：TODOあり
   └─ show.php            # 詳細（完成済み）
```

## 実装手順（推奨）

1. `create.php` の **STEP 1: CSRF チェック** を実装して通す
2. **STEP 2: 入力の取得とバリデーション**（user 存在/数量）を実装
3. **STEP 3: 単価を DB から取得**し、**合計をサーバ計算**
4. **STEP 4: トランザクション**で orders + order_items の登録
5. **STEP 5: PRG(303)** で `show.php` に遷移
6. エラーパス（例外/バリデーション NG）時に **フラッシュで errors/old を設定し new.php へ**

## 受け入れチェック（最低限）

- [ ] 正常系：2 商品（2,1 など）で作成 → `show.php` に明細と合計が表示される
- [ ] CSRF 改ざん → 拒否される（400 相当 or エラーメッセージ）
- [ ] すべて数量 0 / 負数 / 100 以上 → エラー表示し入力保持
- [ ] `orders/index.php` に新しい注文が表示される
- [ ] 出力 XSS（ユーザー名に `<script>` を埋めても実行されない）

## 注意

- **PDO のプリペアド＋バインド**を使い、文字列連結 SQL は禁止です
- `security.php` に `csrf_field()` / `verify_csrf()` / `e()` / `flash_set()` などがあるので活用してください
