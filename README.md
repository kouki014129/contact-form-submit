✅ これをREADME.mdにコピペ（完全版）
# お問い合わせフォーム（Contact Form）

## 環境構築

### Dockerビルド

```bash
git clone git@github.com:【あなたのユーザー名】/contact-form.git
cd contact-form
docker compose up -d --build
```

### Laravel環境構築
```bash
docker compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 開発環境
- お問い合わせ画面：http://localhost:84
- ユーザー登録：http://localhost:84/register
- phpMyAdmin：http://localhost:8084

### 使用技術（実行環境）

- PHP 8.2.x
- Laravel 8.x
- MySQL 8.0.26
- nginx 1.21.1
- Docker / docker compose

### ER図
![ER図](src/public/images/er.png)
