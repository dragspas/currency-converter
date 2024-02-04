<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Currency Converter

The repository contains a simple interface for currency conversion, built with PHP 8.3, Laravel v10 and MySQL. The application provides exchange rates update through a third-party API.

## Requirements

- Docker installed on your machine
- PHP 8.3 installed
- Composer installed

## Instructions

- Clone project from GitHub https://github.com/dragspas/currency-converter

```
git clone https://github.com/dragspas/currency-converter.git
```

- Create .env file, will not be included in the repo

```
cp .env.example .env
```

You need to add value for CURRENCY_LAYER_APP_ID

- Than run commands

```
touch storage/logs/laravel.log
composer install

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan config:cache
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

- To update exchange rates run

```
./vendor/bin/sail artisan rates:update
```

- After successful transaction, run command:

```
./vendor/bin/sail artisan queue:work
```

- Go to http://localhost and make conversions

- To review sent emails, go to http://localhost:8025

## Comments

- Search for `@note` in the project to find some improvements suggestions, ideas and clarifications
