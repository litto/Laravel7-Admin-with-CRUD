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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('cms/list','CmsController@list');
Route::post('cms/list','CmsController@list');
Route::get('cms/unpublish_record/{id?}','CmsController@unpublish_record');
Route::get('cms/publish_record/{id?}','CmsController@publish_record');
Route::get('cms/delete_record/{id?}','CmsController@delete_record');
Route::get('cms/edit/{id?}','CmsController@edit');
Route::post('cms/update/{id?}','CmsController@update');
Route::post('cms/store','CmsController@store');
Route::resource('cms', 'CmsController');

