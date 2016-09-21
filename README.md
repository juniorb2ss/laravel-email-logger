# Laravel Email Logger

Possible to armazenate all emails send by application in Redis, Database or Elasticsearch.

## Installation

Laravel Email Logger can be installed via [composer](http://getcomposer.org) by requiring the `juniorb2ss/laravel-email-logger` package in your project's `composer.json`.

```json
{
    "require": {
        "juniorb2ss/laravel-email-logger": "1.*"
    }
}
```

Next add the service provider and the alias to `app/config/app`.

```php
'providers' => [
    // ...
    Juniorb2ss\LaravelEmailLogger\LaravelEmailLoggerServiceProvider::class,
],
```


Now, run this in terminal:

```bash
php artisan vendor:publish --provider="Juniorb2ss\LaravelEmailLogger\LaravelEmailLoggerServiceProvider" --tag="migrations"

php artisan migrate
```

## Configurations

Later.
