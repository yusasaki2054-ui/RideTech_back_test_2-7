-- 01_seed.sql
USE appdb;

-- users
INSERT INTO users (name, email, age, status, created_at) VALUES
('Taro',  'taro@example.com',   28, 'active',   '2024-01-05 09:00:00'),
('Mika',  'mika@gmail.com',     32, 'active',   '2024-02-10 10:00:00'),
('Ken',   'ken@yahoo.co.jp',    41, 'trial',    '2024-03-15 11:00:00'),
('Ann',   'ann@example.com',    23, 'active',   '2024-04-01 08:30:00'),
('Bob',   'bob@company.co',     36, 'inactive', '2024-05-20 12:00:00'),
('Yuki',  'yuki@gmail.com',     29, 'active',   '2024-06-18 13:00:00'),
('Sora',  'sora@example.com',   45, 'trial',    '2024-07-22 14:00:00'),
('Mei',   'mei@yahoo.co.jp',    31, 'active',   '2024-08-09 15:00:00'),
('Riku',  'riku@example.com',   52, 'active',   '2024-09-30 16:00:00'),
('Hana',  'hana@gmail.com',     27, 'active',   '2024-10-12 17:00:00'),
('Leo',   'leo@company.co',     34, 'trial',    '2024-11-08 18:00:00'),
('Aya',   'aya@example.com',    22, 'active',   '2024-12-25 19:00:00'),
('Noa',   'noa@mail.com',       26, 'active',   '2025-01-12 09:00:00'),
('Kai',   'kai@example.com',    38, 'inactive', '2025-01-25 12:30:00'),
('Ren',   'ren@gmail.com',      33, 'active',   '2025-02-05 08:45:00'),
('Koki',  'koki@yahoo.co.jp',   44, 'trial',    '2025-02-14 10:10:00'),
('Sara',  'sara@example.com',   21, 'active',   '2025-02-20 11:15:00'),
('Shun',  'shun@company.co',    35, 'active',   '2025-03-03 09:30:00'),
('Nana',  'nana@gmail.com',     28, 'trial',    '2025-03-10 13:00:00'),
('Haru',  'haru@example.com',   31, 'active',   '2025-03-20 14:20:00'),
('Rio',   'rio@yahoo.co.jp',    27, 'inactive', '2025-04-01 15:45:00'),
('Mao',   'mao@company.co',     40, 'active',   '2025-04-12 16:10:00'),
('Yuta',  'yuta@example.com',   30, 'active',   '2025-04-25 09:00:00'),
('Rina',  'rina@gmail.com',     29, 'trial',    '2025-05-02 10:20:00'),
('Saki',  'saki@example.com',   24, 'active',   '2025-05-15 11:40:00'),
('Taiki', 'taiki@yahoo.co.jp',  46, 'inactive', '2025-05-28 12:55:00'),
('Aoi',   'aoi@company.co',     33, 'active',   '2025-06-05 14:05:00'),
('Hinata','hinata@gmail.com',   22, 'trial',    '2025-06-12 15:25:00'),
('Karin', 'karin@example.com',  37, 'active',   '2025-07-01 09:05:00'),
('Itsuki','itsuki@yahoo.co.jp', 42, 'active',   '2025-07-10 10:35:00');

-- categories
INSERT INTO categories (name, created_at) VALUES
('Beverages', '2024-01-01 00:00:00'),
('Snacks',    '2024-01-01 00:00:00'),
('Seasonal',  '2024-01-01 00:00:00'),
('Electronics','2024-01-01 00:00:00'),
('Grocery',   '2024-01-01 00:00:00'),
('Books',     '2024-01-01 00:00:00'),
('Home',      '2024-01-01 00:00:00'),
('Sports',    '2024-01-01 00:00:00'),
('Toys',      '2024-01-01 00:00:00');

-- products
INSERT INTO products (name, price, category_id, created_at) VALUES
('Coffee',            480, 1, '2024-01-02 09:00:00'),
('Latte',             520, 1, '2024-01-02 09:10:00'),
('Tea',               300, 1, '2024-01-02 09:20:00'),
('Cookie',            250, 2, '2024-01-03 10:00:00'),
('Chips',             220, 2, '2024-01-03 10:10:00'),
('Seasonal Mug',      900, 3, '2024-01-04 11:00:00'),
('Christmas Blend',  1200, 3, '2024-01-04 11:10:00'),
('Headphones',       7800, 4, '2024-01-05 12:00:00'),
('USB-C Cable',       800, 4, '2024-01-05 12:10:00'),
('Unused Gadget',    1500, 4, '2024-01-05 12:20:00'), -- 未購入商品（問題15用）
('Espresso',          450, 1, '2024-01-02 09:30:00'),
('Green Tea',         320, 1, '2024-01-02 09:40:00'),
('Brownie',           280, 2, '2024-01-03 10:20:00'),
('Pasta',             300, 5, '2024-01-06 11:30:00'),
('Olive Oil',         980, 5, '2024-01-06 11:35:00'),
('Kettle',           3500, 7, '2024-01-07 12:30:00'),
('Vacuum Cleaner',  15800, 7, '2024-01-07 12:40:00'),
('Novel',            1200, 6, '2024-01-08 13:00:00'),
('Magazine',          600, 6, '2024-01-08 13:10:00'),
('Yoga Mat',         2200, 8, '2024-01-09 14:00:00'),
('Dumbbells',        4200, 8, '2024-01-09 14:10:00'),
('Trail Shoes',      9800, 8, '2024-01-09 14:20:00'),
('Chocolate Bar',     200, 2, '2024-01-03 10:25:00');

-- orders
-- 2023（古い）
INSERT INTO orders (user_id, order_date, total_amount, created_at) VALUES
(1, '2023-12-20',  980.00, '2023-12-20 10:00:00'), -- Taro
(5, '2023-11-05', 1200.00, '2023-11-05 11:00:00'); -- Bob

-- 2024（テスト中心）
INSERT INTO orders (user_id, order_date, total_amount, created_at) VALUES
(1, '2024-01-10',  800.00, '2024-01-10 09:00:00'),
(2, '2024-02-14', 1320.00, '2024-02-14 10:00:00'),
(3, '2024-03-03',  520.00, '2024-03-03 11:00:00'),
(4, '2024-05-21', 1800.00, '2024-05-21 12:00:00'),
(6, '2024-07-11',  740.00, '2024-07-11 13:00:00'),
(7, '2024-07-22', 2400.00, '2024-07-22 14:00:00'),
(8, '2024-08-09',  300.00, '2024-08-09 15:00:00'),
(9, '2024-10-05', 8200.00, '2024-10-05 16:00:00'),
(10,'2024-12-01',  520.00, '2024-12-01 17:00:00'),
(11,'2024-12-25', 1500.00, '2024-12-25 18:00:00');

-- 2025（直近・180日判定用）
INSERT INTO orders (user_id, order_date, total_amount, created_at) VALUES
(2, '2025-06-01',  500.00, '2025-06-01 09:00:00'),  -- 180日以内の例
(4, '2025-04-15',  900.00, '2025-04-15 10:00:00'),  -- 180日付近の例
(5,  '2025-02-01', 1250.00, '2025-02-01 10:00:00'),
(13, '2025-03-05',  860.00, '2025-03-05 11:00:00'),
(20, '2025-03-20', 1320.00, '2025-03-20 12:00:00'),
(24, '2025-05-02',  480.00, '2025-05-02 09:00:00'),
(27, '2025-05-28', 7800.00, '2025-05-28 13:00:00'),
(30, '2025-06-15', 3200.00, '2025-06-15 15:00:00'),
(9,  '2025-07-01', 2600.00, '2025-07-01 09:00:00'),
(16, '2025-08-12',  540.00, '2025-08-12 10:00:00');

-- orders（アイテム無しの孤立注文：問題20用）
INSERT INTO orders (user_id, order_date, total_amount, created_at) VALUES
(12,'2024-09-09',  999.00, '2024-09-09 10:00:00'), -- Aya: アイテム無し
(3, '2024-04-04',  777.00, '2024-04-04 09:00:00'),  -- Ken: アイテム無し
(21,'2024-11-11',  555.00, '2024-11-11 11:11:00'),  -- Rio: アイテム無し
(29,'2025-02-22',  666.00, '2025-02-22 12:22:00');  -- Karin: アイテム無し

-- order_items
-- 2023
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(1, 1, 1, 480.00), (1, 3, 1, 300.00), (1, 4, 2, 250.00);         -- 2023-12-20
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(2, 7, 1, 1200.00);                                               -- 2023-11-05

-- 2024（各月ばらけさせる）
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(3,  2, 1, 520.00), (3, 4, 1, 250.00);                            -- 2024-01-10
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(4,  1, 1, 480.00), (4, 2, 1, 520.00), (4, 6, 1, 900.00);         -- 2024-02-14
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(5,  3, 1, 300.00), (5, 4, 1, 250.00);                            -- 2024-03-03
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(6,  8, 1, 7800.00), (6, 9, 1, 800.00);                           -- 2024-05-21
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(7,  5, 2, 220.00), (7, 3, 1, 300.00);                            -- 2024-07-11
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(8,  6, 1, 900.00), (8, 1, 1, 480.00), (8, 7, 1, 1200.00);        -- 2024-07-22
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(9,  3, 1, 300.00);                                                -- 2024-08-09
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(10, 8, 1, 7800.00);                                               -- 2024-10-05
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(11, 2, 1, 520.00);                                                -- 2024-12-01
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(12, 6, 1, 900.00), (12, 7, 1, 1200.00);                           -- 2024-12-25

-- 2025（直近の注文）
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(13, 1, 1, 480.00);                                                -- 2025-06-01
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(14, 4, 2, 250.00), (14, 3, 1, 300.00);                            -- 2025-04-15
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(15, 11, 1, 450.00), (15, 13, 2, 280.00);                           -- 2025-02-01
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(16, 20, 1, 2200.00), (16, 23, 1, 200.00);                          -- 2025-03-05
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(17, 16, 1, 3500.00), (17, 19, 1, 600.00);                          -- 2025-03-20
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(18, 11, 1, 450.00);                                                -- 2025-05-02
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(19, 17, 1, 15800.00);                                              -- 2025-05-28
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(20, 14, 2, 300.00), (20, 15, 1, 980.00);                           -- 2025-06-15
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(21, 5, 1, 220.00), (21, 23, 3, 200.00);                            -- 2025-07-01
INSERT INTO order_items (order_id, product_id, qty, unit_price) VALUES
(22, 18, 1, 1200.00), (22, 12, 1, 320.00);                          -- 2025-08-12

-- logs（いろいろな時間帯・レベル）
INSERT INTO logs (level, message, created_at) VALUES
('info',  'system boot',          '2023-12-31 23:50:00'),
('error', 'disk full',            '2024-01-01 00:05:00'),
('warn',  'cache high',           '2024-01-01 00:10:00'),
('error', 'api timeout',          '2024-01-01 01:15:00'),
('error', 'db lock wait',         '2024-01-01 01:25:00'),
('info',  'cron start',           '2024-02-10 09:00:00'),
('error', 'payment failed',       '2024-02-10 09:12:00'),
('error', 'payment failed',       '2024-02-10 09:35:00'),
('warn',  'memory high',          '2024-03-03 11:00:00'),
('error', 'queue stuck',          '2024-03-03 11:05:00'),
('error', 'queue stuck',          '2024-03-03 11:55:00'),
('info',  'deploy done',          '2024-05-21 12:00:00'),
('error', 'worker died',          '2024-05-21 12:10:00'),
('error', 'worker died',          '2024-05-21 12:20:00'),
('warn',  'slow query',           '2024-07-11 13:10:00'),
('error', 'oom killer',           '2024-07-11 13:20:00'),
('error', 'oom killer',           '2024-07-11 13:40:00'),
('error', 'login brute-force',    '2024-08-09 15:05:00'),
('info',  'rotate logs',          '2024-10-05 16:00:00'),
('error', 'io error',             '2024-10-05 16:10:00'),
('error', 'io error',             '2024-10-05 16:20:00'),
('error', 'unexpected 500',       '2024-12-01 17:05:00'),
('error', 'unexpected 500',       '2024-12-01 17:15:00'),
('warn',  'cdn 4xx',              '2024-12-25 18:30:00'),
('error', 'cdn 5xx',              '2024-12-25 18:35:00'),
('error', 'cdn 5xx',              '2024-12-25 18:45:00'),
('info',  'rollover',             '2025-01-01 00:00:00'),
('error', 'auth fail',            '2025-03-10 08:05:00'),
('warn',  'cache near limit',     '2025-03-10 08:10:00'),
('error', 'timeout',              '2025-04-15 10:05:00'),
('error', 'timeout',              '2025-04-15 10:15:00'),
('info',  'batch done',           '2025-06-01 09:30:00'),
('error', 'rate limit',           '2025-06-01 09:35:00'),
('error', 'rate limit',           '2025-06-01 09:50:00'),
('warn',  'cache flush',          '2025-06-01 10:05:00'),
('error', 'db reconnect',         '2025-06-01 10:10:00'),
('error', 'db reconnect',         '2025-06-01 10:20:00'),
('error', 'cache miss storm',     '2025-07-01 09:10:00'),
('info',  'scale up workers',     '2025-07-01 09:15:00'),
('warn',  'disk near full',       '2025-07-15 13:00:00'),
('error', 'db deadlock',          '2025-07-15 13:05:00'),
('info',  'db deadlock resolved', '2025-07-15 13:07:00'),
('error', 'payment webhook retry','2025-08-12 10:20:00'),
('error', 'payment webhook retry','2025-08-12 10:25:00'),
('warn',  'rate limit nearing',   '2025-08-12 10:30:00'),
('info',  'feature flag on',      '2025-08-20 11:00:00'),
('error', 'worker OOM',           '2025-08-20 11:05:00');

-- 補足：検証用のビュー/クイック確認（任意）
-- SELECT COUNT(*) FROM users;
-- SELECT COUNT(*) FROM products;
-- SELECT COUNT(*) FROM orders;
-- SELECT COUNT(*) FROM order_items;
-- SELECT COUNT(*) FROM logs;
