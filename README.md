<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# Laravel Notebook
Notebook is a interactive note taking application created to organize your notes on the web. I made this with Laravel 7 and Vue js.

## What are the functionalities of Notebook 
- Users can register themselves an account and starting taking notes.
- BASIC CRUD for ```Notebooks``` and ```Notes``` with Vue JS.
- A inline WYSIWIG Editor to edit your notes content seamlessly.

### Steps for Installation
```
git clone https://github.com/sanz/Laravel-Notebook.git laravel-notebook
cd laravel-notebook
composer install
cp .env.example .env
php artisan migrate --seed
php artisan key:generate
php artisan storage:link
php artisan serve
```

- If you find the repository helpful, hit that star :)
