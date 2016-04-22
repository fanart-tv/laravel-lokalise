# laravel-lokalise
Console integration with lokali.se

This is a very simple pair of files that will allow you to use `php artisan lang:push` and `php artisan lang:pull` to automatically push your base language and import your translations to and from https://lokali.se

## Requirements
These scripts use GuzzleHttp so make sure that is installed first via composer

## Assumptions
As I mentioned this is currently a very simple pair of files, as such it makes the following assumptions
* your base language is english
* all your translatable strings reside in app.php
* you already have a folder created in the lang directory for the language you want to pull in

## Installation
Put LangPull.php and LangPush.php in /app/Console/Commands/

add

    Commands\LangPush::class,
    Commands\LangPull::class,

to `protected $commands = [ array` in /app/Console/Kernal.php

Update both files

    protected $apikey = 'YOUR_API_KEY';
    protected $project = 'YOUR_PROJECT_KEY';
    
In /config/app.php

    'site_lang' => [
        'en' => [
            'name' => 'English',
        ],
        'de' => [
            'name' => 'German',
        ],
    ],

Only the array key is used in the lookup, I use the values in my app but they aren't necessary for the language file

## Usage

    php artisan lang:push
This will push your base language file up to locali.se replacing what is currently there and adding additional keys

    php artisan:pull
This will pull every translation, then it will match it against your array of languages, skip the english one and add any others.  Additionally if the lang is es_ES it will change it to just es

