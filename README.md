# Splat Build
##  A Splatoon 2 Gear Logger and Planner
- Create Head, Clothing, and Shoe gears from Splatoon 2
- Assemble gearsets with the existing gears you've created
- See gear stats in real-time using [Lean's algorithm](https://github.com/Leanny)
- Search through your gears and gearsets (future release)
### How to run locally
1. Clone the repo `git clone https://github.com/sandeepsingh11/splat-build.git`
2. Switch into directory `cd splat-build`
3. Run `composer install`
4. Copy **.env.development** to create **.env** (`cp .env.development .env`)
5. Update APP_ENV=local in **.env**
6. Run `php artisan key:generate`
7. Test if **server.php** works
    - Run `php artisan serve` and navigate to the local server
    - If you see the local website, you're good to go
    - If an error shows a missing **server.php** file, there is a chance your anti virus deleted it. [Check the notes below](#notes)
    - Press `Ctrl+C` into the terminal to stop the local server
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
    - Check the _users_ table for an existing username
    - Password = demo
### Notes
* Error on step 7: If an error shows a missing **server.php** file, there is a chance your anti virus deleted it. Change your anti virus setting to ignore that specific directory, or set it to ask you what to do with a suspicious file before the software deletes it for you. Then, try to paste the **server.php** file from the repo into your local. If that does not work, delete your local repo, and re-clone this repo.
    - [Related StackOverflow question](https://stackoverflow.com/questions/50283368/server-php-file-missing-fatal-error)