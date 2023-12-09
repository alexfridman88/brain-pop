<div style="text-align: center;">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</div>

<div style="text-align: center;">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</div>

# Install


## Windows:

* Go to the docker folder and run `.\build.bat` file on your computer.
* Next, in same `docker` folder, run `docker compose up -d` command for install docker containers.
* After that, run `.\terminal.bat` to open the Docker command line (CLI).
* Inside Docker, run `composer install` to get what the project needs.
* Finally, run `php artisan migrate` in Docker CLI to set everything up.

## Mac:

* Go to the docker folder and run `docker run --rm -it -v ${PWD}/../:/var/www/html montebal/laradev:php80-2204 -c "composer install"` command.
* Next, in same `docker` folder, run `docker compose up -d` command for install docker containers.
* After that, run `- docker exec -it pop_api bash` to open the Docker command line (CLI).
* Inside Docker, run `composer install` to get what the project needs.
* Finally, run `php artisan migrate` in Docker CLI to set everything up.

### After install

* Change in the `.env` file line `DB_HOST=127.0.0.1` to `DB_HOST=mysql` line.
* Make a new database for this project and add it to `.env` as `DB_DATABASE=brain_pop`.
