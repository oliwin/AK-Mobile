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

Auth::routes();

Route::get("/", "HomeController@index");

Route::group(['middleware' => ['auth:web']], function () {

  Route::resource('objects', 'ObjectController');
  Route::resource('prototypes', 'PrototypeController');
  Route::resource('fields', 'PrototypeFieldsController');
  Route::resource('categories', 'CategoryController');

  ## OBJECTS ##
  Route::get("prototypes/{id}/objects", "ObjectController@filterByPrototype");
  Route::get("objects/{id}/clone", "ObjectController@cloneObject");

  ## FIELDS ##
  Route::get("prototype/fields/{id}", "PrototypeFieldsController@fieldsInPrototype");
  Route::get("fields/type/{id}", "PrototypeFieldsController@fields");


});
