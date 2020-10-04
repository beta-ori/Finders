<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PagesController@index');

Route::get('/home', 'PagesController@index')->name('home');

Route::get('/about', 'PagesController@about');

Route::get('/doctors', 'PagesController@doctors');

Route::get('/hospitals', 'PagesController@hospitals');

Route::get('/nearby-hospitals', 'PagesController@nearbyHospitals');

Route::get('/hospital', 'PagesController@hospital');

Route::get('/profile', 'PagesController@profile');

Route::get('/register/option', 'PagesController@registerOption')->name('register.option');

Route::get('/hospital/create', 'PagesController@hospitalForm')->middleware('auth');

Route::get('/doctor/appointment', 'PagesController@appointment')->middleware('auth');


Route::get('/doctor/register', 'PagesController@doctorForm');

Route::post('/doctor/appointment', 'PagesController@createAppointment')->middleware('auth');

Route::post('/doctor/register', 'PagesController@createDoctor');

Route::post('/hospital/create', 'PagesController@createHospital');

Route::post('/doctors', 'PagesController@findDoctors');
   
Auth::routes();

Route::get('admin', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');



