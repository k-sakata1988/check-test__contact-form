# お問い合わせフォーム

## 環境構築
Dockerビルド
1. git clone @github.com:k-sakata1988/check-test__contact-form.git
2. docker-compose up -d --build

Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## 使用技術
- PHP 8.1.33
- Laravel 10.49.0
- MySQL 8.0.26
- Nginx 1.21
- Docker 28.3.2 /Docker Compose 3.8

## ER図


## URL
- 開発環境: http://localhost/
- phpMyAdmin: http://localhost:8080/