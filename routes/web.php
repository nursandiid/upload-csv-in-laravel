<?php

use App\Http\Controllers\LogImportsController;
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

Route::get('/', [LogImportsController::class, 'index'])->name('log_import.index');
Route::get('/data', [LogImportsController::class, 'data'])->name('log_import.data');
Route::post('/import', [LogImportsController::class, 'store'])->name('log_import.store');