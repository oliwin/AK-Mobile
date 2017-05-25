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

## Get JSON by ways ##
Route::get('config/db', "API\ObjectController@db");
Route::get('config/json', "API\ObjectController@json");

## Update JSON file from model ##
Route::get("config/update", "API\ObjectController@update");
