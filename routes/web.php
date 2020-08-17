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

Route::get('/', 'ProfilDosenController@index');
Route::get('/semua-dosen', 'ProfilDosenController@semuaDosen');
Route::get('/cari', 'ProfilDosenController@cariDosen');
Route::get('/dosen/{id}/{any}', 'ProfilDosenController@profilDosen');
Route::get(cb()->getAdminPath().'/profile/resetdata', 'ProfilDosenController@resetDataDosen');
