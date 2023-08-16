# Improving App Quality: Exploring Browser Testing with Laravel Dusk
This is an implementation of Browser Testing in Laravel with Laravel Dusk. A blog about this can be found here: [Improving App Quality: Exploring Browser Testing with Laravel Dusk | Fajarwz](https://fajarwz.com/blog/improving-app-quality-exploring-browser-testing-with-laravel-dusk/).

## Installation

### Composer Packages 
```
composer install
```

## Configuration

### Create `.env` file from `.env.example`
```
cp .env.example .env
```

### Generate Laravel App Key
```
php artisan key:generate
```

### Database Integration
1. Create a database and connect it with Laravel with filling the DB name in `DB_DATABASE`
2. Adjust `DB_USERNAME`
3. Adjust `DB_PASSWORD`
4. Adjust `APP_URL`
```
# make sure this is the correct host and port
APP_URL=http://localhost:8000
```

### Migrate the Database Migration
```
php artisan migrate
```

## Run App
```
php artisan serve
```

## Run the Dusk Tests
```
php artisan dusk
```