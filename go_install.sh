./go_create_user_and_db.sh
cp .env.tasks .env
composer install
php artisan key:generate && php artisan jwt:secret
php artisan migrate  && php artisan db:seed --class=UserSeeder
./go_privilege.sh
php artisan serve
