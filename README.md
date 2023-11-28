<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## #How to start the project

The project uses laravel sail, so we need to start the docker containers. Rename the `.env.example` to `.env` and add 
```
SAIL_XDEBUG_MODE=develop,debug
```
if you want to use step debugging.

**Next run**:
```
sail up -d
```
```
sail composer install --ignore-platform-reqs
```
```
sail php artisan key:generate
```
After that, you need to run:
```
sail artisan migrate
```
and
```
sail npm run dev
```
as it uses Vite in some places.

## #Important notice
to also run two commands that populate `Tags` and `Categories` tables with data from the swagger API.
```
sail artisan app:populate-tags-table
```
```
sail artisan app:populate-categories-table
```
These commands upsert (update or insert) data so there shouldn't be any duplicates in the database after multiple runs.
