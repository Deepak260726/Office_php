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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard2', 'LaraController@index')->name('dashboardnew');

/****************** START :: SUPPORT **********************/
// Support
Route::group(['as' => 'support'], function () {

  Route::get('/support', 'Support\SupportController@index');
  Route::get('/support/search', 'Support\SupportController@search');

});
/****************** END :: SUPPORT **********************/






