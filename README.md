## Laravel Twitter Clone

### Prerequisites
* [Docker](https://www.docker.com/)

### Installation

#### Build and start Docker services

```bash
docker-compose up --build -d
```

#### Connect to php-fpm (app) container

```bash
docker-compose exec app sh
```

#### Copy .env file

```bash
cp .env.example .env
```

#### Install the dependencies

```bash
composer install
```

#### Run the database migration and seeder (if needed)

```bash
php artisan migrate --seed
```

#### Run the tests

```bash
bin/phpunit
```

### Fix style
composer fix-styles

## If anything information need to load for new changes code then added by below command
composer ide-generate

#### Add necessarey dev dependencies
. Install barryvdh/laravel-debugbar
. Install barryvdh/laravel-ide-helper
. Install matt-allan/laravel-code-style


### Email configuration github link
. https://github.com/laravel/ui/blob/3.x/src/AuthRouteMethods.php
. https://github.com/laravel/ui/blob/3.x/auth-backend/VerifiesEmails.php

### After sending email then run the comman manually
php artisan queue:work

### To check which languaage selected by cache/ config/app.php
php artisan tinker
>>> app()->getLocale();
### Above problem resolve by cache clear
php artisan cache:clear
php artisan config:cache

