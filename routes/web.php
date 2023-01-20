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

Auth::routes();

Route::get('/Hospitals', [App\Http\Controllers\HospitalController::class, 'index'])->name('displayHospitals');
Route::post('/Hospitals/Create', [App\Http\Controllers\HospitalController::class, 'store'])->name('storeHospital');
Route::get('/Hospitals/{id}/Main', [App\Http\Controllers\HospitalController::class, 'main'])->name('viewHospitalMain');
Route::get('/Hospitals/{id}/Community', [App\Http\Controllers\HospitalController::class, 'community'])->name('viewHospitalCommunity');

Route::post('/Hospitals/CreateLocation', [App\Http\Controllers\LocationController::class, 'store'])->name('storeLocation');

Route::post('/Hospitals/CreateBoard', [App\Http\Controllers\BoardController::class, 'store'])->name('storeBoard');
Route::get('/Hospitals/Boards/{id}', [App\Http\Controllers\BoardController::class, 'show'])->name('showBoard');

Route::post('/Hospitals/UploadTest', [App\Http\Controllers\TestController::class, 'store'])->name('storeTest');
Route::get('/Hospitals/DownloadTest/{id}', [App\Http\Controllers\DownloadController::class, 'downloadTest'])->name('downloadTest');