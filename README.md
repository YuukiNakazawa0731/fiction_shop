# Fiction Shop

架空のオンラインショップ「Fiction Shop」の PHP アプリケーションです。トップページ（新着・SALE）、商品一覧、カート、注文、アカウント登録/ログイン、管理向けの簡易ページを含みます。

## 特徴

- レスポンシブ対応（PC/タブレット/スマホの CSS を分離）
- 商品一覧・在庫表示・カート投入
- ログイン/新規登録（配送先を登録）
- 注文履歴・特定商取引法表示/プライバシーポリシー
- 管理（商品管理・注文管理・商品登録）

## ディレクトリ構成

```
fiction_shop/
  shop.php                # トップページ
  header.php, footer.php  # 共通ヘッダー/フッター
  shop.js                 # 画面動作用JS
  css/                    # 画面サイズ別CSS
    full/, middle/, mobile/
  images/                 # UI画像（アイコン等）
  item_img/               # 商品画像
  other/
    base_cont.php         # セッション/共通関数（サニタイズ等）
    img_cont.php
    shop_DB.php           # DB接続（PDO）
    shop_DB(saver).php    # （バックアップ用の想定ファイル）
    account/              # アカウント関連
      login.php, mycart.php, signup_check.php, delete_cart_cont.php
    products/             # 商品関連
      all.php, item_manage.php, item_signup.php, item_edit.php
    support/              # サポート/注文関連
      order_cont.php, order_manage.php, order_result.php, order_thank.php, labels.php, privacy.php
```

## 動作要件

- PHP 7.4 以上（PDO 拡張が有効であること）
- MySQL 5.7+ / MariaDB 10.3+（デフォルト設定は DB 名: `shop`）
- Web サーバー（Apache 推奨）または PHP 内蔵サーバー
- jQuery（本リポジトリ外参照。後述の注意点を参照）

## 作成者

**仲澤勇樹 (Nakazawa Yuuki)**

- GitHub: [@YuukiNakazawa0731](https://github.com/YuukiNakazawa0731)
- Portfolio: [Full Throttle Vue](https://yuukinakazawa0731.github.io/full_throttle_v/)
