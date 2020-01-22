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
Route::get('/search', 'PostController@search')->name('posts.search');
Route::get('/categories', 'CategoryController@siteIndex')->name('category.site.index');
Route::get('/category/{id}', 'CategoryController@show')->name('category.site.show');
Route::post('/posts/like', 'PostController@like')->name('posts.like');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::resource('posts', 'PostController')->except(['show']);
	Route::resource('categories', 'CategoryController')->except(['show']);
	Route::resource('comments', 'CommentController')->only(['index', 'store', 'destroy']);

	Route::post('upload-editor', 'PostController@uploadEditor')->name('image.editor');
	Route::post('/posts/switch', 'PostController@switchPublish')->name('posts.switch');
	Route::post('/comments/switch', 'CommentController@switchPublish')->name('comments.switch');
});
