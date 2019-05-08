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

Route::get('/', 'PagesController@home');
Route::get('/new_residents', 'PagesController@new_residents');
Route::get('/privacy', 'PagesController@privacy');
Route::get('/terms', 'PagesController@terms');
Route::get('/register', 'PagesController@register');
Route::get('/login', 'PagesController@login');

Route::resource('/users', 'UserController');

/*Route::resource('projects', 'ProjectsController');
Route::resource('tasks', 'TaskController');*/