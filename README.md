# Laravel eShop API test app.
Документация по API находится в eshop_postman.json - можно импортировать в Postman.

## Prerequisites
1. [PHP 8.1](https://www.php.net/downloads)
2. [PostgreSQL](https://www.postgresql.org/download/)
3. [Git](https://git-scm.com/)
4. [Composer](https://getcomposer.org/download/)

## Steps
1. `git clone https://github.com/ivanoid768/eshop_api_laravel_test_task.git`

2. `cd eshop_api_laravel_test_task`

3. `В posgres создать базу данных eshop (username=postgres, password=postgres, port=5432)`

4. `php artisan migrate`

5. `php artisan db:seed --class="CategorySeeder"`
6. `php artisan db:seed --class="ProductSeeder"`
7. `php artisan db:seed --class="DatabaseSeeder"`

8. `php artisan serve`

9.  Import eshop_postman.json to Postman and run requests to http://localhost:8000/