# laravel-map
This small project allows you to create an address book with a visualization on an [OpenStreetMap](https://www.openstreetmap.org/) map.

## Installation
After selecting a folder, please activate the following command:
```shell
composer require "papposilene/laravel-map"
```
It will install [Laravel](http://laravel.com/) and all the packages for the proper functioning of the application.

After installation, several operations should be automatically performed. But, you can launch them yourself with the commands below:
```shell
php artisan storage:link
php artisan migrate --seed
php artisan cache:clear
```

## Customization
Laravel creates an .env file in the folder at the root of the project.
- You can enclose the name of your card in the "APP_NAME" variable in quotation marks.
- In the same file, you can choose your language. Translations are planned for English and French. You can add your language (see the [Laravel](https://laravel.com/docs/5.8/localization)).

## Packages
- [Laravel-Excel](https://github.com/maatwebsite/Laravel-Excel).