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
Route::post('home/getJsonData', 'HomeController@getJsonData')->name('home.get-json-data');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

    Route::prefix('admin')->group(function(){
        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
    });

    Route::prefix('admin-crud')->group(function(){
        Route::get('/', 'AdminCrudController@index')->name('admin-crud');
        Route::post('/anyData','AdminCrudController@anyData');
    });

    Route::prefix('data-import')->group(function(){
        Route::get('/', 'DataImportController@index')->name('data-import');
        Route::post('/import-file', 'DataImportController@importFile')->name('data-import.import-file');
        Route::get('/anyData','DataImportController@anyData');
    });

    Route::prefix('trend')->group(function(){
        Route::get('/', 'TrendController@index')->name('trend');
        Route::post('/getJsonData', 'TrendController@getJsonData')->name('data-import.get-json-data');
    });


