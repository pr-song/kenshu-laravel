<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

/** 
 * アドミンのルート 
 */
Route::name('admin.')->group(function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
        /** アドミンダッシュボード */
        Route::get('/', 'PagesController@dashboard')->name('dashboard');

        /** ユーザー管理のルート */
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
        Route::get('/users/{id}/roles/assign_role', 'UsersController@assignRole')->name('users.assign_role');
        Route::match(['put', 'patch'], '/users/{id}/roles', 'UsersController@updateRole')->name('users.update_role');

        /** 記事管理のルート */
        Route::get('/articles', 'ArticlesController@index')->name('articles.index');

        /** タグ管理のルート */
        Route::resource('/tags', 'TagsController')->except([
            'show'
        ]);

        /** 役割管理のルート */
        Route::get('/roles', 'RolesController@index')->name('roles.index');
        Route::get('/roles/create', 'RolesController@create')->name('roles.create');
        Route::post('/roles', 'RolesController@store')->name('roles.store');
    });
});

/** 認証のルート */
Auth::routes();

/** ホームページのルート */
Route::get('/', 'PagesController@index')->name('home');

/** Articleのルート */
Route::resource('articles', 'ArticlesController')->parameters([
    'articles' => 'slug'
]);
Route::get('/my_articles', 'ArticlesController@myArticles')->name('articles.my_articles');
