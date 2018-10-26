# laravel-shibboleth-middleware
Simple middleware solution to Shibboleth authentication that works in Laravel 5.5.

### Installation
* Copy file to app\Http\Middlware.
* Add `'shibboleth' => \App\Http\Middleware\Shibboleth::class,` to `$routeMiddleware` in app/Http/Kernel.php.
* Add `'user' => env('APP_USER', null),` to config/app.php
* Add `APP_USER=blah` to .env file
* Run `php artisan config:cache`
* Update `\App\Http\Controllers\Auth\LoginController` using `LoginController.php`
* Add routes to `routes/web.php`:
```
Route::get('login', 'Auth\LoginController@login')->name('login');
Route::get('shibboleth', 'Auth\LoginController@shibboleth')->name('shibboleth');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
```


### Use
To apply middleware to a group of routes:
```php
// Public routes can go here

Route::group(['middleware' => 'shibboleth'], function() {
     // Protected routes can go in here
});
```

Add the following to the top of `public/.htaccess`:
```
<IfModule mod_shib>
    AuthType shibboleth
    ShibRequestSetting requireSession false
    require shibboleth
</IfModule>
```
