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
Route::get('/Hospitals/Tests', [App\Http\Controllers\TestController::class, 'index'])->name('displayTests');

Route::post('/Hospitals/CreateLocation', [App\Http\Controllers\LocationController::class, 'store'])->name('storeLocation');

Route::post('/Hospitals/CreateBoard', [App\Http\Controllers\BoardController::class, 'store'])->name('storeBoard');
Route::get('/Hospitals/Boards/{id}', [App\Http\Controllers\BoardController::class, 'show'])->name('showBoard');

Route::post('/Hospitals/UploadTest', [App\Http\Controllers\TestController::class, 'store'])->name('storeTest');
Route::get('/Hospitals/DownloadTest/{id}', [App\Http\Controllers\DownloadController::class, 'downloadTest'])->name('downloadTest');

Route::get('/Hospitals/Admin', [App\Http\Controllers\AdminController::class, 'index'])->name('showAdmin');
Route::post('/Hospitals/Admin/Prices', [App\Http\Controllers\PriceController::class, 'store'])->name('storeDefect');

Route::get('/Hospitals/Admin/Invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('showInvoice');
Route::post('/Hospitals/Admin/Invoices', [App\Http\Controllers\InvoiceController::class, 'store'])->name('storeInvoice');
Route::post('/Hospitals/Admin/Invoices/Paid', [App\Http\Controllers\InvoiceController::class, 'paid'])->name('paidInvoice');

Route::get('/Hospitals/Board/Remedials', [App\Http\Controllers\RemedialController::class, 'index'])->name('displayRemedial');
Route::get('/Hospitals/Board/Remedials/Create', [App\Http\Controllers\RemedialController::class, 'create'])->name('createRemedial');
Route::post('/Hospitals/Board/Remedials/Create', [App\Http\Controllers\RemedialController::class, 'store'])->name('storeRemedial');
Route::get('/Hospitals/Board/Remedials/{id}', [App\Http\Controllers\RemedialController::class, 'show'])->name('showRemedial');
Route::post('/Hospitals/Board/Remedials/approve', [App\Http\Controllers\RemedialController::class, 'approve'])->name('approveRemedial');

Route::get('/send', [App\Http\Controllers\MailController::class, 'index']);