# Fiction Shop

このリポジトリは、架空のオンラインショップ「Fiction Shop」のWebアプリケーションです。

## 構成

- `shop.php`, `header.php`, `footer.php`, `shop.js` : メインページや共通パーツ
- `css/` : 各デバイス向けのスタイルシート
- `images/`, `item_img/` : 画像素材
- `other/` : サーバーサイド処理やDB関連ファイル
  - `account/` : アカウント関連
  - `products/` : 商品管理
  - `support/` : サポート・注文関連

## 主な機能
- 商品一覧・詳細表示
- カート・注文機能
- アカウント登録・ログイン
- 管理者による商品管理

## 必要環境
- PHP 7.x 以上
- Webサーバー (Apache, Nginx など)

## セットアップ
1. このリポジトリをクローン
2. Webサーバーのドキュメントルートに配置
3. 必要に応じて `other/shop_DB.php` などのDB設定を編集

## ライセンス
このプロジェクトはMITライセンスです。
