# Churchy

## Overview
Laravel was chosen for this project due to its robust MVC structure, built-in Eloquent ORM for database management, and efficient job queue system.
This is the web app corresponding to the APi 

## Stack 
- Swaggger OpenAPI
- Queue/jobs (for large requests)
- Spatie (Roles & permissions)
- Passport (Oauth)
- Redis(Cache, Queue connection)
- PHPUnit (Unit tests & Feature tests)
- S3 (Storage)

## Prerequisites
Ensure you have the following installed:
- PHP 8.0+
- Composer
- MySQL
- Laravel 10.0+

Ensure you have the following installed:
- PHP 8.0+
- Composer
- MySQL/MariaDB
- Laravel 10.0+

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/MohamedThioune/churchy.git
   cd churchy
   ```
2. **Install dependencies:**
   ```sh
   composer install
   ```
3. **Set up the environment:**
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials:
   ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE={confidential}
    DB_USERNAME={confidential}
    DB_PASSWORD={confidential}
   ```
4. **Run migrations:**
   ```sh
   php artisan migrate
   ```
5. **Run the application:**
   ```sh
   php artisan serve
   ```

## Database Migration

To apply the migrations, run:
```sh
php artisan migrate
```

To rollback the last migration, use:
```sh
php artisan migrate:rollback
```

To reset all migrations and re-run them:
```sh
php artisan migrate:refresh
```

## API Endpoints

### Swagger Documentation
The API is documented using Swagger. To access the interactive documentation,
Run the following command to generate the Swagger documentation:
php artisan l5-swagger:generate
Visit:
```
http://127.0.0.1:8000/api/documentation
```

## Additional Considerations
- **Error Handling:** Proper validation and error responses are implemented.
- **Scalability:** The batch processing logic ensures large files are processed efficiently using queues.
- **Security:** Authentication and authorization can be added.

## Running Tests
Run API tests using:
```sh
php artisan test
```

## Author
Developed by Mohamed Thioune alias MAXBIRD

## License
Maxbird 

