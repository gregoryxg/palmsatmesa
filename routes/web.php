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


Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'PagesController@home');
Route::get('/new_residents', 'PagesController@new_residents');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/terms', 'PagesController@terms');

Route::resource('/user', 'UserController')->middleware('verified');

Route::resource('/event', 'EventController')->middleware('verified');
Route::get('/reservations', 'EventController@reservations')->middleware('verified');
Route::post('/reservables/{id}/timeslots', 'ReservableController@timeslots')->middleware('verified');

Route::resource('/ticket', 'TicketController')->middleware('verified');
