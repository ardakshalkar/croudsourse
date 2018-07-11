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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/','HomeController@index');


Auth::routes();

Route::get('/home', 'HomeController@index');



Route::resource('users', 'UserController');



Route::resource('posts', 'PostController');

Route::resource('audarmas', 'AudarmaController');


Route::resource('tags', 'TagController');


Route::post('translations/vote', 'TranslationController@vote2');
Route::get('translations/vote', 'TranslationController@vote2');

Route::resource('translations', 'TranslationController');


Route::resource('users', 'UserController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('audarmas/create', 'AudarmaController@create')->name('audarmas');

Route::post('posts/create', array('as' => 'create', 'uses' => 'SearchController@executeSearch'));

Route::post('audarmas/create', array('as' => 'create', 'uses' => 'SearchController@executeSearch'));
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
