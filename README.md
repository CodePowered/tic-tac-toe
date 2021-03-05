# Tic-Tac-Toe

## Description
This is a coding example for famous Tic-Tac-Toe game.

Controllers are covered with Functional tests, while there could be more of Unit tests for corner cases.

## Service dependencies
- PHP 7.4
- MySQL 5.7

## Running application
1. Install PHP libraries (`composer`).
1. Install and compile UI:  
   `yarn encore dev`
1. Make sure you have configured `DATABASE_URL` in **.env.local** or **.env.dev.local**.
1. Create the database and schema only once by running the following commands:  
   `bin/console doctrine:database:create`  
   `bin/console doctrine:schema:create`
1. Run the application with:  
   `symfony serve`

## Running tests
1. Make sure you have configured `DATABASE_URL` in **.env.test.local** with different database name.
1. Create the database only once by running the following command:  
   `bin/console doctrine:database:create --env=test`
1. Run the tests:  
   `bin/phpunit`
