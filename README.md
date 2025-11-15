#　環境構築

## Dockerビルド
git clone git@github.com:rin-25/mogitate-test.git. 
docker-compose up -d --build. 

## Laravel環境構築
docker-compose exec php bash. 
composer install. 
.envファイルの変数を変更. 
php artisan key:generate. 
php artisan migrate. 
php artisan db:seed. 

# 使用技術
Laravel 8.83.29. 
PHP 8.1.33. 
MySQL 8.0.26. 
nginx 1.21.1. 

# ER図
mogitate.drawio.png

