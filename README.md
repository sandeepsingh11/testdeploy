# Splat Build
## How to test locally
1. Clone the repo: `git clone ???`
2. Switch into the clone's directory
3. Run `composer install`
4. Copy **.env.dev** to create **.env** (`cp .env.dev .env`)
5. Update APP_ENV=local in **.env**
6. Run `php artisan key:generate`
7. Test if **server.php** works
    * Your anti virus may delete server.php when serving the repo. To test this, run `php artisan serve` and navigate to the home page
    * If an error shows a missing **server.php** file, there is a chance your anti virus deleted it. Change your anti virus setting to ignore that specific directory, or set it to ask you what to do with a suspicious file before the software deletes it for you. Then, try to paste the **server.php** file from the repo into your local. If that does not work, delete your local repo, and re-clone this repo.
    - [Related StackOverflow question](https://stackoverflow.com/questions/50283368/server-php-file-missing-fatal-error)
8. Create a database
    - Splat Build uses PostgreSql. For the GUI I use [PG Admin 4 v5](https://www.pgadmin.org/download/)
    - Create a new database with default settings
    - Update the DB_DATABASE, DB_USERNAME, and DB_PASSWORD values in **.env**
9. Run `php artisan migrate`
10. Run `php artisan db:seed`
11. Run `php artisan storage:link`
12. Run `npm install`
13. Start the server `php artisan serve`
14. Log into the site to start using!
    - Check the users table for an existing username
    - Password = demo