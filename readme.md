# Laravel Hetras API wrapper

<p align="center"> 
<a href="https://packagist.org/packages/kg-bot/laravel-hetras"><img src="https://img.shields.io/packagist/dt/kg-bot/laravel-hetras.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/kg-bot/laravel-hetras"><img src="https://img.shields.io/packagist/v/kg-bot/laravel-hetras.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/kg-bot/laravel-hetras"><img src="https://img.shields.io/packagist/l/kg-bot/laravel-hetras.svg?style=flat-square" alt="License"></a>
</p>

## Installation

1. Require using composer

``` bash
composer require kg-bot/laravel-hetras
```

In Laravel 5.5, and above, the package will auto-register the service provider. In Laravel 5.4 you must install this service provider.

2. Add the HetrasServiceProvider to your `config/app.php` providers array.

``` php
<?php 
'providers' => [
    // ...
    \Hetras\HetrasServiceProvider::class,
    // ...
]
```

3. Copy the package config to your local config with the publish command: 

``` bash
php artisan vendor:publish --provider="Hetras\HetrasServiceProvider"
```