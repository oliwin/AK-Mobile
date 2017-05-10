<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('objects', "API\ObjectController@index");

## Get JSON by ways ##
Route::get('config/db', "API\ObjectController@showJson");
Route::get('config/json', "API\ObjectController@showJsonFromFile");

## Update JSON file from model ##
Route::get("config/update", "API\ObjectController@updateJsonFile");
