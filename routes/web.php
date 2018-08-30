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
        Route::post('/getDetailsById', 'AdminController@getDetailsById')->name('admin.getdetailbyid');
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
    });

    Route::prefix('admin-crud')->group(function(){
        Route::post('/anyData','AdminCrudController@anyData');
        Route::post('/add','AdminCrudController@add')->name('admin-crud.add');
        Route::post('/update','AdminCrudController@update')->name('admin-crud.update');
        Route::post('/delete','AdminCrudController@delete')->name('admin-crud.delete');
        Route::get('/', 'AdminCrudController@index')->name('admin-crud');
    });

    Route::prefix('data-import')->group(function(){
        Route::post('/import-file', 'DataImportController@importFile')->name('data-import.import-file');
        Route::get('/anyData','DataImportController@anyData');
        Route::get('/', 'DataImportController@index')->name('data-import');
    });

    Route::prefix('trend')->group(function(){
        Route::post('/getJsonData', 'TrendController@getJsonData')->name('data-import.get-json-data');
        Route::get('/getTrendLines', 'TrendController@getTrendLines')->name('data-import.get-trend-line');
        Route::post('/saveTrendLines', 'TrendController@saveTrendLines')->name('data-import.save-trend-line');
        Route::post('/removeTrendLines', 'TrendController@removeTrendLines')->name('data-import.remove-trend-line');
        Route::post('/saveToJsonFile', 'TrendController@saveToJsonFile')->name('data-import.save-json-file');
        Route::get('/', 'TrendController@index')->name('trend');
    });


