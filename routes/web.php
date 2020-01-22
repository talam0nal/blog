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

Route::get('/', 'HomeController@main')->name('site.main');
Route::get('/posts/{id}', 'PostController@show')->name('posts.show');
Route::get('/user/{id}', 'PostController@byUser')->name('posts.user');
Route::post('/posts/like', 'PostController@like')->name('posts.like');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::resource('posts', 'PostController')->except(['show']);
	Route::resource('categories', 'CategoryController')->except(['show']);
	Route::post('upload-editor', 'PostController@uploadEditor')->name('image.editor');
	Route::post('/posts/switch', 'PostController@switchPublish')->name('posts.switch');
});
