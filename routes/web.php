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
Route::get('/MainSearch', [App\Http\Controllers\HospitalController::class, 'mainSearch'])->name('MainSearch');
Route::get('/Hospitals/{id}/Community', [App\Http\Controllers\HospitalController::class, 'community'])->name('viewHospitalCommunity');
Route::get('/Hospitals/Community/Search', [App\Http\Controllers\HospitalController::class, 'communitySearch'])->name('searchHospitalCommunity');
Route::get('/Hospitals/{id}/Main/OldTests', [App\Http\Controllers\OldTestController::class, 'oldMain'])->name('viewOldMain');
Route::get('/Hospitals/{id}/Community/OldTests', [App\Http\Controllers\OldTestController::class, 'oldCommunity'])->name('viewOldCommunity');
Route::get('/Hospitals/Tests', [App\Http\Controllers\TestController::class, 'index'])->name('displayTests');
Route::get('/Hospitals/Tests/{id}', [App\Http\Controllers\TestController::class, 'hospitals'])->name('displayHospitalTests');

Route::post('/Hospitals/CreateLocation', [App\Http\Controllers\LocationController::class, 'store'])->name('storeLocation');
Route::post('/Hospitals/EditLocation', [App\Http\Controllers\LocationController::class, 'edit'])->name('editLocation');
Route::get('/Hospitals/Location/{id}', [App\Http\Controllers\LocationController::class, 'view'])->name('viewLocation');
Route::delete('/DeleteLocation/{id}', [App\Http\Controllers\LocationController::class, 'delete'])->name('deleteLocation');

Route::post('/Hospitals/CreateBoard', [App\Http\Controllers\BoardController::class, 'store'])->name('storeBoard');
Route::post('/Hospitals/EditBoard', [App\Http\Controllers\BoardController::class, 'edit'])->name('editBoard');
Route::get('/Hospitals/Boards/{id}', [App\Http\Controllers\BoardController::class, 'show'])->name('showBoard');
Route::delete('/DeleteBoard/{id}', [App\Http\Controllers\BoardController::class, 'delete'])->name('deleteBoard');
Route::post('/Hospitals/CircuitLayout', [App\Http\Controllers\BoardController::class, 'circuitLayout'])->name('storeCircuitDiagram');

Route::post('/Hospitals/UploadTest', [App\Http\Controllers\TestController::class, 'store'])->name('storeTest');
Route::get('/Hospitals/DownloadTest/{id}', [App\Http\Controllers\DownloadController::class, 'downloadTest'])->name('downloadTest');
Route::delete('/DeleteTest/{id}', [App\Http\Controllers\TestController::class, 'delete'])->name('deleteTest');
Route::post('/Hospitals/UploadOldTest', [App\Http\Controllers\OldTestController::class, 'store'])->name('storeOldTest');
Route::get('/Hospitals/DownloadOldTest/{id}', [App\Http\Controllers\OldTestController::class, 'download'])->name('downloadOldTest');

Route::post('/Hospitals/UploadDrawing', [App\Http\Controllers\DrawingController::class, 'store'])->name('storeDrawing');
Route::get('/Hospitals/DownloadDrawing/{id}', [App\Http\Controllers\DrawingController::class, 'download'])->name('downloadDrawing');
Route::delete('/DeleteDrawing/{id}', [App\Http\Controllers\DrawingController::class, 'delete'])->name('deleteDrawing');

Route::get('/Hospitals/Admin', [App\Http\Controllers\AdminController::class, 'index'])->name('showAdmin');
Route::post('/Hospitals/Admin/Prices', [App\Http\Controllers\PriceController::class, 'store'])->name('storeDefect');
Route::post('/Hospitals/Admin/Prices/Edit', [App\Http\Controllers\PriceController::class, 'edit'])->name('editDefect');

Route::get('/Hospitals/Admin/Invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('showInvoice');
Route::post('/Hospitals/Admin/Invoices', [App\Http\Controllers\InvoiceController::class, 'store'])->name('storeInvoice');
Route::post('/Hospitals/Admin/Invoices/Paid', [App\Http\Controllers\InvoiceController::class, 'paid'])->name('paidInvoice');

Route::get('/Hospitals/Board/Remedials', [App\Http\Controllers\RemedialController::class, 'index'])->name('displayRemedial');
Route::get('/Hospitals/Board/Remedials/Create', [App\Http\Controllers\RemedialController::class, 'create'])->name('createRemedial');
Route::post('/Hospitals/Board/Remedials/Create', [App\Http\Controllers\RemedialController::class, 'store'])->name('storeRemedial');
Route::get('/Hospitals/Board/Remedials/{id}', [App\Http\Controllers\RemedialController::class, 'show'])->name('showRemedial');
Route::post('/Hospitals/Board/Remedials/approve', [App\Http\Controllers\RemedialController::class, 'approve'])->name('approveRemedial');
Route::post('/Hospitals/Board/Remedials/complete', [App\Http\Controllers\RemedialController::class, 'complete'])->name('completeRemedial');
Route::post('/Hospitals/Board/Remedials/edit', [App\Http\Controllers\RemedialController::class, 'edit'])->name('editRemedial');
Route::delete('/DeleteRemedial/{id}', [App\Http\Controllers\RemedialController::class, 'delete'])->name('deleteRemedial');

Route::get('/Schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('showSchedule');
Route::post('/Schedule', [App\Http\Controllers\ScheduleController::class, 'store'])->name('storeSchedule');
Route::get('/Schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'show'])->name('showEvent');
Route::post('/Schedule/approve', [App\Http\Controllers\ScheduleController::class, 'approve'])->name('approveSchedule');
Route::post('/Schedule/complete', [App\Http\Controllers\ScheduleController::class, 'complete'])->name('completeSchedule');
Route::post('/Schedule/notes', [App\Http\Controllers\ScheduleController::class, 'notes'])->name('addScheduleNote');
Route::post('/Schedule/edit', [App\Http\Controllers\ScheduleController::class, 'edit'])->name('editSchedule');
Route::delete('/DeleteSchedule/{id}', [App\Http\Controllers\ScheduleController::class, 'delete'])->name('deleteSchedule');
Route::post('/Schedule/notes/edit', [App\Http\Controllers\ScheduleController::class, 'editNote'])->name('editScheduleNote');
Route::get('/DeleteScheduleNote/{id}', [App\Http\Controllers\ScheduleController::class, 'deleteNote'])->name('deleteNoteSchedule');

