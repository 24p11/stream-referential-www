# Referential www

## Requirements
* node v10.X.X
* php 7.4.X
* composer
* mysql 8.0.X

## Download configure

### Download

`git clone https://github.com/24p11/stream-referential-www.git`

### Configure

Copy and rename `.env.example`  to `env` 

Configure MySQL database connection parameters

##### Run following commands:

`npm run production`

`php artisan test`

`php artisan migrate to create all table`

Optional `php artisan db:seed` to load some fixtures data

Start local server `php artisan serve`

Open http://127.0.0.1:8000
