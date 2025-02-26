<?php

use App\Http\Controllers\C_Database;
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

Route::view("/", "pages.dashboard")->name("dashboard");

Route::prefix("db")->controller(C_Database::class)->group(function () {
    Route::get("processing", "processing")->name("db.processing");
    Route::get("processing-data", "processingData")->name("db.processing-data");
    Route::get("processing/add", "getProcessingAdd")->name("db.processing.add");
    Route::post("processing/add", "postProcessingAdd")->name("db.processing.post-add");
});
