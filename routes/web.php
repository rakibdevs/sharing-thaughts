<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', 'ContentController@show');
	Route::get('/content', 'ContentController@show');

	Route::post('/topic/store', 'TopicController@store');
	Route::post('/topic/update/{id}', 'TopicController@update');
	Route::get('/topic/delete/{id}', 'TopicController@destroy');

	Route::post('/section/store', 'SectionController@store');
	Route::post('/section/update/{id}', 'SectionController@update');
	Route::get('/section/delete/{id}', 'SectionController@destroy');
	Route::get('/section/show/{id}', 'SectionController@show');

	Route::get('/page/create', 'PageController@create');
	Route::post('/page/store', 'PageController@store');
	Route::get('/page/show/{id}', 'PageController@show');
	Route::get('/page/edit/{id}', 'PageController@edit');
	Route::post('/page/update/{id}', 'PageController@update');
	Route::get('/page/delete/{id}', 'PageController@destroy');

	Route::get('/attatchment/delete/{id}', 'PageController@destroyAtt');
	Route::post('/attatchment/add/', 'PageController@addAtt');

	Route::get('/shared', 'ShareController@shared');
	Route::get('/shared/{id}/{slug}', 'ShareController@sharedContent');

	Route::get('/share/public/{id}', 'ShareController@shareToAll');
	Route::post('/share/private/{id}', 'ShareController@share');
	Route::post('/share/private-update/{id}', 'ShareController@shareUpdate');
	Route::get('/share/edit/{id}', 'ShareController@edit');
	Route::get('/share/public-remove/{id}', 'ShareController@shareRemoveAll');
	Route::get('/share/private-remove/{id}', 'ShareController@shareRemove');




	Route::post('/media/store', 'pageController@media');


	Route::get('/search', 'SearchController@search')->name('search');
	/*Route::get('/search/user', 'SearchController@user');*/

});

