<?php

use App\Http\Controllers\InventarisController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect(route('login'));
})->name('landing');

Auth::routes([
    'register' => false
]);

Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::resource('aset', ItemController::class)->only([
    'index',
    'show',
    'edit',
    'update',
]);
Route::resource('inventaris', InventarisController::class);
Route::get('report', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
Route::get('report/cetak/{jenis}', [App\Http\Controllers\ReportController::class, 'cetak'])->name('report.cetak');
Route::get('report/inventaris', [App\Http\Controllers\ReportController::class, 'inventaris'])->name('report.inventaris');
