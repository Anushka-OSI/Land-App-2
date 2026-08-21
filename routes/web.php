<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\FindController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// About Us & Subcategories
Route::prefix('about')->name('about')->group(function () {
    Route::get('/', [AboutController::class, 'index']);
    Route::get('/overview', [AboutController::class, 'overview'])->name('.overview');
    Route::get('/organization-chart', [AboutController::class, 'organizationChart'])->name('.organization-chart');
    Route::get('/aims', [AboutController::class, 'aims'])->name('.aims');
});

// Services & Subcategories
Route::prefix('services')->name('services')->group(function () {
    Route::get('/', [ServicesController::class, 'index']);
    Route::get('/title-registration', [ServicesController::class, 'titleRegistration'])->name('.title-registration');
    Route::get('/land-registration', [ServicesController::class, 'landRegistration'])->name('.land-registration');
});

// Find Page
Route::match(['get', 'post'], '/find', [FindController::class, 'index'])->name('find');
