1 > composer create-project --prefer-dist laravel/laravel laravel-vue-practise
2 > npm install
3 > npm install admin-lte@versionname --save
npm install admin-lte@v3.0.0-alpha.2 --save
4 > php artisan make:auth
5 > php artisan migrate
You will get - Syntax error or access violation: 1071 Specified key was too long; max key
  length is 767 bytes
Go to AppServiceProvider
public function boot()
    {
        Schema::defaultStringLength(191);
    }
    use Illuminate\Support\Facades\Schema;
6 > php artisan migrate:fresh
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<script src="{{ asset('js/app.js') }}"></script>
by default app.blade.php is the main file from which home.blade.php is created
7 > Go to resources/assets/js/bootstrap.js
Add:  
require('admin-lte');
8 > Go to resources/assets/sass/app.scss
Add:
@import "~admin-lte/dist/css/adminlte.css";
9 > npm run watch (resourses css / js is compiled to public css / js)
10 > Go to https://www.flaticon.com/ 
Then save images (profile and logo to public/img/)
11 > https://fontawesome.com/start then scroll page and go to sass
npm install --save-dev @fortawesome/fontawesome-free

in app.scss (Refer to the font and svg icon)
$fa-font-path:"../webfonts"; 
@import "~@fortawesome/fontawesome-free/scss/fontawesome.scss";
@import "~@fortawesome/fontawesome-free/scss/solid.scss";
@import "~@fortawesome/fontawesome-free/scss/brands.scss";

12 > Change profile and logo on master.blade.php
13 > font awesome icon is not working so go to matser.blade.php and add proper font awesome icon
