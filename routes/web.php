<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'digging_deeper',], function () {
    Route::get('collections', 'DiggingDeeperController@collections')
            ->name('digging_deeper.collections');
});

Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', 'PostController')->names('blog.posts');
});


//> Админка блога
$groupData = [
    'namespace' => 'Blog\Admin', //папка, где искать контроллеры
    'prefix'    => 'admin/blog',
];
Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index', 'edit', 'store', 'update', 'create'];
    Route::resource('categories', 'CategoryController')
        ->only($methods) //создай маршруты, только с этими методами
        ->names('blog.admin.categories'); //задаем имя маршрутам

    //BlogPost
    Route::resource('posts', 'PostController')
        ->except(['show']) //нужны методы все, кроме show (показать статью)
        ->names('blog.admin.posts');
});
//<






//Route::resource('rest', 'RestTestController')->names('restTest');















