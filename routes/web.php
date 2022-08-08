<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/verification/resend/{id}', 'Auth\VerificationController@resend');
Route::get('/user/verify/{token}', 'Auth\VerificationController@verifyEmail');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'PagesController@home')->name('index');
Route::get('/new_residents', 'PagesController@new_residents');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/terms', 'PagesController@terms');

Route::resource('/user', 'UserController');

Route::resource('/event', 'EventController');
Route::post('/validate', 'EventController@validateEvent');
Route::get('/checkout', 'EventController@checkout');
Route::get('/confirmEvent/{id}', 'EventController@confirmEvent');
Route::get('/reservations', 'EventController@reservations');
Route::post('/reservables/{id}/timeslots', 'ReservableController@timeslots');
Route::post('/reservables/locations', 'ReservableController@locations');

Route::resource('/ticket', 'TicketController');
Route::get('/closed_ticket', 'TicketController@closed');
Route::get('/ticket/{ticket}/close', 'TicketController@close');

Route::resource('/committeeticket', 'CommitteeTicketController');
Route::post('/committeeticket/{id}/assign', 'CommitteeTicketController@assign');
Route::get('/user_committeeticket', 'CommitteeTicketController@user_assigned');
Route::get('/assigned_committeeticket', 'CommitteeTicketController@assigned');
Route::get('/closed_committeeticket', 'CommitteeTicketController@closed');

Route::post('/ticketComment', 'TicketCommentController@store');

//Admin functions

Route::get('/admin','AdminController@index');
Route::get('/admin/users', 'AdminController@searchUser');
Route::post('/admin/users', 'AdminController@userResults');
Route::get('/admin/editUser/{id}', 'AdminController@editUser');
Route::patch('/admin/updateUser/{id}', 'AdminController@updateUser');

Route::get('/admin/reservables', 'AdminController@reservables');
Route::get('/admin/reservables/{id}', 'AdminController@reservable');
