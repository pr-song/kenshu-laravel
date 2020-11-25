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

/** 認証のルート */
Auth::routes();

/** ホームページのルート */
Route::get('/', 'PagesController@index')->name('home');

/** Articleのルート */
Route::resource('articles', 'ArticlesController')->parameters([
    'articles' => 'slug'
]);
Route::get('/myarticles', 'ArticlesController@myarticles')->name('articles.myarticles');
