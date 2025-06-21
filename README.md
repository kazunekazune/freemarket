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

![ER図](er_diagram.png)

<details>
<summary>ER図の元データ (GitHub上では自動で図になります)</summary>

```mermaid
erDiagram
    users {
        unsigned_bigint id PK "主キー"
        varchar name NN
        varchar email UK, NN
        timestamp email_verified_at
        varchar profile_image
    }

    items {
        unsigned_bigint id PK "主キー"
        unsigned_bigint user_id FK "users(id)への外部キー"
        varchar name NN
        text description NN
        integer price NN
        varchar condition NN
        varchar image_path
        timestamp sold_at
    }

    likes {
        unsigned_bigint id PK "主キー"
        unsigned_bigint user_id FK "users(id)への外部キー"
        unsigned_bigint item_id FK "items(id)への外部キー"
    }

    comments {
        unsigned_bigint id PK "主キー"
        unsigned_bigint user_id FK "users(id)への外部キー"
        unsigned_bigint item_id FK "items(id)への外部キー"
        text comment NN
    }

    purchases {
        unsigned_bigint id PK "主キー"
        unsigned_bigint user_id FK "users(id)への外部キー"
        unsigned_bigint item_id FK "items(id)への外部キー"
    }

    categories {
        unsigned_bigint id PK "主キー"
        varchar name UK, NN
    }

    category_item {
        unsigned_bigint item_id FK "items(id)への外部キー"
        unsigned_bigint category_id FK "categories(id)への外部キー"
    }

    users ||--o{ items : "出品する"
    users ||--o{ likes : "いいねする"
    users ||--o{ comments : "コメントする"
    users ||--o{ purchases : "購入する"

    items ||--o{ likes : "いいねされる"
    items ||--o{ comments : "コメントされる"
    items |o--|| purchases : "購入される"

    items }o--o{ category_item : "持つ"
    categories }o--o{ category_item : "属する"
```

</details>

---

## URL

開発環境でアクセスする URL は以下の通りです。

-   **アプリケーション**: [http://localhost/](http://localhost/)
-   **phpMyAdmin** (DB 管理ツール): [http://localhost:8080/](http://localhost:8080/)
-   **MailHog** (メール確認ツール): [http://localhost:8025/](http://localhost:8025/)
