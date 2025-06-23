# フリマアプリ

## 概要
LaravelとDockerを使用したフリマアプリケーションです。商品の出品・購入・いいね・コメント機能を提供します。

## 環境構築

### 前提条件
- Docker Desktop がインストールされていること
- Git がインストールされていること

### 1. リポジトリのクローン

```bash
git clone https://github.com/kazunekazune/freemarket.git
cd freemarket
```

### 2. Docker コンテナの起動

プロジェクトのルートディレクトリで以下のコマンドを実行し、Docker コンテナをビルドしてバックグラウンドで起動します。

```bash
docker-compose up -d --build
```

### 3. Laravel 環境のセットアップ

次に、`php`コンテナ内で Laravel アプリケーションの初期設定を行います。

```bash
# PHPライブラリのインストール
docker-compose exec php composer install

# .envファイルの作成
docker-compose exec php cp .env.example .env

# アプリケーションキーの生成
docker-compose exec php php artisan key:generate

# データベースのマイグレーション（テーブル作成）
docker-compose exec php php artisan migrate

# 初期データの投入（ダミーユーザー、商品、カテゴリーなど）
docker-compose exec php php artisan db:seed

# 画像などを公開するためのシンボリックリンクを作成
docker-compose exec php php artisan storage:link
```

### 4. 動作確認

ブラウザで [http://localhost/](http://localhost/) にアクセスして、アプリケーションが正常に表示されることを確認してください。

---

## 使用技術 (実行環境)

- **PHP**: 8.2.11
- **Laravel Framework**: 8.83.9
- **MySQL**: 8.0
- **nginx**: 1.21.1
- **Bootstrap**: 5.3.0

---

## ER図

![ER図](https://github.com/user-attachments/assets/7fccfcb1-9d55-41ac-8469-3ed65c18791c)

### データベース構成
- **users**: ユーザー情報管理
- **items**: 商品情報管理
- **likes**: いいね機能
- **comments**: コメント機能
- **purchases**: 購入履歴
- **categories**: カテゴリー管理
- **category_item**: 商品とカテゴリーの関連テーブル

---

## URL

開発環境でアクセスする URL は以下の通りです。

- **アプリケーション**: [http://localhost/](http://localhost/)
- **phpMyAdmin** (DB 管理ツール): [http://localhost:8080/](http://localhost:8080/)
- **MailHog** (メール確認ツール): [http://localhost:8025/](http://localhost:8025/)

---

## 主な機能

- ユーザー登録・ログイン
- 商品の出品・編集・削除
- 商品の検索・閲覧
- 商品の購入
- いいね機能
- コメント機能
- カテゴリー別商品表示

---

## トラブルシューティング

### ポートが使用されている場合
```bash
# コンテナを停止
docker-compose down

# 使用中のポートを確認
netstat -an | grep :80
```

### コンテナが起動しない場合
```bash
# ログを確認
docker-compose logs

# コンテナを再ビルド
docker-compose up -d --build --force-recreate
```

### データベース接続エラーの場合
1. `.env`ファイルのDB設定を確認
2. MySQLコンテナが起動しているか確認
3. マイグレーションが正常に実行されているか確認