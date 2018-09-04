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
    if(Auth::guard('web')->check()){
        return redirect('home');
    }elseif(Auth::guard('admin')->check()){
        return redirect('admin');
    }else{
        $result = DB::table('currency')->select('id_currency', 'currency_name')->get();
        $data = array();
        foreach($result as $item){
            $row = array();
            $row['id'] = $item->id_currency;
            $row['item'] = $item->currency_name;
            $data[] = $row;
        }
        return view('welcome', ['js' => "root", 'select2' => $data]);
    }
})->name('root');

Auth::routes();

Route::post('/chart-data/getChartData', 'ChartDataController@getChartData')->name('chart-data.get-chart-data');
Route::get('/chart-data/getTrendLines', 'ChartDataController@getTrendLines')->name('chart-data.get-trend-line');

Route::post('home/getChartData', 'HomeController@getChartData')->name('home.get-chart-data');
Route::get('home/getTrendLines', 'HomeController@getTrendLines')->name('home.get-trend-line');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

    Route::prefix('profile')->group(function(){
        Route::post('/checkEmail', 'HomeController@checkEmail')->name('profile.checkEmail');
        Route::get('/getDetails', 'HomeController@getDetails')->name('profile.getDetails');
        Route::post('/update','HomeController@update')->name('profile.update');
        Route::post('/updatePassword','HomeController@updatePassword')->name('profile.updatePassword');
        Route::get('/', 'HomeController@profile')->name('profile');
    });

    Route::prefix('admin')->group(function(){
        Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
        Route::post('/getDetailsById', 'AdminController@getDetailsById')->name('admin.getdetailbyid');
        Route::get('/profile', 'AdminController@profile')->name('admin.profile');
        Route::post('/checkEmail', 'AdminController@checkEmail')->name('admin.checkEmail');
        Route::get('/getDetails', 'AdminController@getDetails')->name('admin.getDetails');
        Route::post('/update','AdminController@update')->name('admin.update');
        Route::post('/updatePassword','AdminController@updatePassword')->name('admin.updatePassword');
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
    });

    Route::prefix('manage-admin')->group(function(){
        Route::post('/anyData','AdminCrudController@anyData');
        Route::post('/add','AdminCrudController@add')->name('manage-admin.add');
        Route::post('/update','AdminCrudController@update')->name('manage-admin.update');
        Route::post('/delete','AdminCrudController@delete')->name('manage-admin.delete');
        Route::post('/checkEmail','AdminCrudController@checkEmail')->name('manage-admin.checkEmail');
        Route::post('/resetPassword','AdminCrudController@resetPassword')->name('manage-admin.resetPassword');
        Route::get('/', 'AdminCrudController@index')->name('manage-admin');
    });

    Route::prefix('data-import')->group(function(){
        Route::post('/import-file', 'DataImportController@importFile')->name('data-import.import-file');
        Route::post('/anyData','DataImportController@anyData');
        Route::get('/', 'DataImportController@index')->name('data-import');
    });

    Route::prefix('trend')->group(function(){
        Route::post('/getJsonData', 'TrendController@getJsonData')->name('data-import.get-json-data');
        Route::get('/getTrendLines', 'TrendController@getTrendLines')->name('data-import.get-trend-line');
        Route::post('/saveTrendLines', 'TrendController@saveTrendLines')->name('data-import.save-trend-line');
        Route::post('/removeTrendLines', 'TrendController@removeTrendLines')->name('data-import.remove-trend-line');
        Route::post('/saveToJsonFile', 'TrendController@saveToJsonFile')->name('data-import.save-json-file');
        Route::get('/getCurrency', 'TrendController@getCurrency')->name('data-import.get-currency');
        Route::get('/', 'TrendController@index')->name('trend');
    });

    Route::prefix('setting')->group(function(){
        Route::get('/', 'SettingController@index')->name('setting');
    });



