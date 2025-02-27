<?php

use App\Http\Controllers\C_Auth;
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
# Auth
Route::get("/", [C_Auth::class, 'GetLogin'])->name("GetLogin");
Route::post("/", [C_Auth::class, 'PostLogin'])->name("PostLogin");

Route::prefix("dashboard")->middleware(['check-auth'])->group(function () {
    Route::get("/logout", [C_Auth::class, 'Logout'])->name("Logout");
    Route::view("/", "pages.dashboard")->name("dashboard");
    Route::prefix("db")->controller(C_Database::class)->group(function () {
        Route::group(["prefix" => "processing"], function () {
            Route::get("", "processing")->name("db.processing");
            Route::get("data", "processingData")->name("db.processing-data");
            Route::get("add", "getProcessingAdd")->name("db.processing.add");
            Route::post("add", "postProcessingAdd")->name("db.processing.post-add");
            Route::get("edit/{id}", "getProcessingEdit")->name("db.processing.edit");
            Route::post("edit/{id}", "postProcessingEdit")->name("db.processing.post-edit");
            Route::get("delete/{id}", "getProcessingDelete")->name("db.processing.delete");
            Route::get("export/excel", "exportProcesExcel")->name("db.processing.export-excel");
            Route::get("export/pdf", "exportProcesPdf")->name("db.processing.export-pdf");
        });
        Route::group(["prefix" => "breed"], function () {
            Route::get("", "breed")->name("db.breed");
            Route::get("data", "breedData")->name("db.breed-data");
            Route::get("add", "getBreedAdd")->name("db.breed.add");
            Route::post("add", "postBreedAdd")->name("db.breed.post-add");
            Route::get("edit/{id}", "getBreedEdit")->name("db.breed.edit");
            Route::post("edit/{id}", "postBreedEdit")->name("db.breed.post-edit");
            Route::get("delete/{id}", "getBreedDelete")->name("db.breed.delete");
            Route::get("export/excel", "exportBreedExcel")->name("db.breed.export-excel");
            Route::get("export/pdf", "exportBreedPdf")->name("db.breed.export-pdf");
        });
    });
});
