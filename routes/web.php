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
Route::get('/titasi-dosen/{id}', 'ProfilDosenController@getTitasi');
Route::get(cb()->getAdminPath().'/profile/resetdata', 'ProfilDosenController@resetDataDosen');

Route::get(cb()->getAdminPath().'/chart/jurusan/{tipe}/{tahun_awal}/{tahun_akhir}', 'DashboardController@getChartJurusan');

Route::group(['middleware' => ['web', \ersaazis\cb\middlewares\CBBackend::class], 'prefix' => cb()->getAdminPath()], function () {
    Route::get('/chart/dosen/{tipe}/{tahun_awal}/{tahun_akhir}', 'DashboardController@getChartDosen');

    Route::get('/users/import', 'crud\UserManagementController@import');
    Route::post('/users/import/save', 'crud\UserManagementController@importSave');

    Route::get('/cari_dokumen/dokumen/{id_dokumen}/{simpan}', 'AdminCariDokumenController@simpanDokumen');
    Route::get('/dokumen_saya/private/{id}/{jenis}', 'AdminDokumenSayaController@status');
    Route::get('/dokumen_saya/hapus/{id_dokumen}', 'AdminDokumenSayaController@hapusDokumen');
    Route::get('/rekomendasi_dokumen/hapus/{id_dokumen}', 'AdminRekomendasiDokumenController@hapusDokumen');
    Route::get('/rekomendasi_dokumen/reset', 'AdminRekomendasiDokumenController@resetDokumen');
});