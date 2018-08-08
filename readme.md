Dev use :

    cd exercises/july_laravel_vuejs/map_application

    php artisan serve

    npm run watch
    npm run watch-poll

In case of troubles with the watch :
    php artisan cache:clear
    composer dump-autoload


Installation :

Clone repository:

    git clone git@github.com:AdrienMariez/map_application.git

Go in the folder:

    cd map_application

Install all laravel dependencies:

    composer install

Modify .env file for Db structure :

    cp .env.example .env

    Modify DB_* value in .env with your database config.

Generate application key:

    php artisan key:generate

Run migration table:

    php artisan migrate

Set auth:

    php artisan jwt:secret

    npm install


Create user:

    php artisan tinker
    >   App\User::create(['name' => 'User', 'email' => 'user@email.com', 'password' => Hash::make('UserPass')])

-------------------
Models :
skycatch-challenge
-------------------
To know what is to be worked on or to be refactoredn, search for :
TEST
TO REMOVE
TO CHANGE
OBSOLETE
-------------------

Need to see :
    http://www.ign.fr/institut/actus/choisir-services-en-ligne-geoportail

may be used :
    Maps :
        https://github.com/xiaokaike/vue-color
        (at least as inspiration)
        https://www.geoportail.gouv.fr/tutoriels
    Color picker : (inspiration)
        http://xiaokaike.github.io/vue-color/

Sources :
    Laravel+vuejs :
        https://github.com/herusdianto/laravel-vue-crud
        https://github.com/anthonygore/vue-laravel-crud
        https://github.com/vicmars5/skycatch-challenge

    database structure for languages :
        https://www.apphp.com/tutorials/index.php?page=multilanguage-database-design-in-mysql

    database multiple rows as primary :
        https://stackoverflow.com/questions/1110349/how-can-i-define-a-composite-primary-key-in-sql

    laravel RESTful API
        https://www.toptal.com/laravel/restful-laravel-api-tutorial
        https://medium.com/js-dojo/the-ultimate-vue-js-laravel-crud-tutorial-3640baf7eda0

    CORS
        https://stackoverflow.com/questions/39429462/adding-access-control-allow-origin-header-response-in-laravel-5-3-passport

    Auth
        https://blog.peterplucinski.com/setting-up-jwt-authentication-with-laravel-and-vue-part-1/
        https://github.com/PeterPlucinski/laravel-vue-jwt

    Images upload
        https://appdividend.com/2018/02/13/vue-js-laravel-file-upload-tutorial/


Good reads :
    Vuejs :
        https://medium.com/@Pier/vue-js-the-good-the-meh-and-the-ugly-82800bbe6684

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
