# フリマアプリ

## 環境構築

### 1. リポジトリのクローン

```bash
git clone <このリポジトリのURL>
cd <リポジトリのディレクトリ名>
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

以上でセットアップは完了です。

---

## 使用技術 (実行環境)

-   **PHP**: 8.2.11
-   **Laravel Framework**: 8.83.9
-   **MySQL**: 8.0
-   **nginx**: 1.21.1
-   **Bootstrap**: 5.3.0

---

## ER 図
![Image](https://github.com/user-attachments/assets/7fccfcb1-9d55-41ac-8469-3ed65c18791c)

## URL

開発環境でアクセスする URL は以下の通りです。

-   **アプリケーション**: [http://localhost/](http://localhost/)
-   **phpMyAdmin** (DB 管理ツール): [http://localhost:8080/](http://localhost:8080/)
-   **MailHog** (メール確認ツール): [http://localhost:8025/](http://localhost:8025/)
