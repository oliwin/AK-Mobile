<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('language/{locale}', function ($locale) {
    App::setLocale($locale);
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {


    /* Regional */


    Route::resource('cabinet/conclusions', 'Cabinet\ConclusionController');

    Route::resource('cabinet/administration/accounting', 'Cabinet\AccountingController');

    Route::resource('cabinet/administration/acts', 'Cabinet\ActsController');

    Route::resource('cabinet/administration/doctors', 'Cabinet\DoctorController');

    Route::resource('cabinet/contacts', 'Cabinet\ContactController');

    Route::get('cabinet/test/file', 'Cabinet\TestController@file');

    Route::get('cabinet/test/form', 'Cabinet\TestController@form');

    Route::resource('cabinet/test', 'Cabinet\TestController');

    Route::post('cabinet/test/file/load', 'Cabinet\TestController@fileUpload');

    Route::resource('cabinet/payment', 'Cabinet\PaymentController');

    Route::get('cabinet/administration', "Cabinet\AdministrationController@index");

    Route::put('cabinet/administration/{id}', array('as' => 'update.administration', 'uses' => 'Cabinet\AdministrationController@update'));

    Route::resource('cabinet/documents', 'Cabinet\DocumentController');

    Route::get('cabinet/statistic/graph', 'Cabinet\StatisticController@graph');

    Route::resource('cabinet/statistic', 'Cabinet\StatisticController@statistic');

    Route::get('cabinet/registered', 'Cabinet\CustomerController@index');

    Route::get('check/applicant', 'Cabinet\CustomerController@getIDN');

    Route::get('cabinet/result', 'Cabinet\TestController@resultTicketView');

    Route::post('cabinet/loadResultTest', 'Cabinet\TestController@loadResultTest');

    Route::post('cabinet/send/results', 'Cabinet\TestController@sendResults');

    Route::post('cabinet/test/change', 'Cabinet\TestController@change');

    Route::get('cabinet/transactions', 'Cabinet\TransactionsController@index');

    Route::get('cabinet/category/edit/{id}', 'Cabinet\CategoryController@edit');

    Route::post('cabinet/category/update', 'Cabinet\CategoryController@set');

    Route::get('cabinet/transaction/details/{id}', 'Cabinet\TransactionsController@show');

    Route::get("counter", "HomeController@counter");


    /* Center */

    Route::resource('cabinet/center/tests', 'Cabinet\Center\TestController', [
        'as' => 'center'
    ]);

    Route::resource('cabinet/center/filials', 'Cabinet\Center\FilialController', [
        'as' => 'center'
    ]);

    Route::resource('cabinet/center', 'Cabinet\Center\HomeController', [
        'as' => 'center'
    ]);

    Route::get('cabinet/center/test/conclusion/{id}', 'Cabinet\Center\TestController@show', [
        'as' => 'center'
    ]);



});

Route::get('datatables', 'DatatablesController@getIndex');
Route::get('datatables/data', 'DatatablesController@anyData');
