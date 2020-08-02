# Bookshelf Service
This app is handle Bookshelf API created with Lumen 7.

### __Pre-Install__
* PHP 7
* Composer

### __Install__
* Opend and setting your .env file
* Add "DB_HOST_LAN" variable on .env file and set value with your endpoint
* Run composer to install all dependency
* Run command below to generate tables and configurate
```
    php artisan reset:database
```
* If you already have database, please, drop all tables

### __Lumen Passport__
This app is using [Lumen Passport](https://github.com/dusterio/lumen-passport) to handle auth.

### __Status Project__
Discontinued