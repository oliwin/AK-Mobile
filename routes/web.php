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
  
  ## SEARCH ##
  Route::get("objects/search", "ObjectController@search");
  Route::get("prototypes/search", "PrototypeController@search");
  Route::get("fields/search", "PrototypeFieldsController@search");

  ## FIELDS ##
  Route::get("fields/prototype/{type}", "PrototypeFieldsController@fields");
  Route::get("prototype/fields/{prototype_id}", "PrototypeFieldsController@fieldsBYID");

  ## OBJECTS ##
  Route::get("prototypes/{id}/objects", "ObjectController@filterByPrototype");
  Route::get("objects/{id}/clone", "ObjectController@cloneObject");
  Route::get("object/add/{id}", "ObjectController@addObjectArray");

  Route::resource('objects', 'ObjectController');
  Route::resource('prototypes', 'PrototypeController');
  Route::resource('fields', 'PrototypeFieldsController');
  Route::resource('categories', 'CategoryController');

});
