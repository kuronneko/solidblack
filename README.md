<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Vue's minimalist blog
### Description: 
Minimalist blog using Jetstream as base with Inertia stack, design for posting articles, personal blogs, tutorials and whatever you want, with a powerful library for enriching text using a custom CkEditor.

### Features adn Technologies:
* Laravel 9 + VueJS 3 + TailwindCSS
* Single-page app using InertiaJS
* AWS EC2 R53
* Custom CKEditor
* Amazing minimalist admin panel and web design
* Dark mode
* Infinite scroll
* Private posts
* Image Storage

### Preview:
<p> <img src="https://kuronneko.github.io/assets/img/portfolioblog.png" width="450"> </p>

How to install [Docker]

    cp .env.example .env
    composer install
    php artisan sail:install
    0,3,5,7
    ./vendor/bin/sail up
    ./vendor/bin/sail php artisan key:generate
    ./vendor/bin/sail php artisan storage:link
    ./vendor/bin/sail php artisan migrate:refresh --seed
    ./vendor/bin/sail build --no-cache (REBUILD IMAGE) (OPTIONAL)

