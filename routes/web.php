<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\FindController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact Us
Route::get('/contact/inquiry', [ContactController::class, 'inquiry'])->name('contact.inquiry');
Route::post('/contact/inquiry', [ContactController::class, 'submitInquiry'])
    ->middleware('throttle:5,1')
    ->name('contact.inquiry.submit');
Route::get('/contact/head-office', [ContactController::class, 'headOffice'])->name('contact.head-office');
Route::get('/contact/regional-office', [ContactController::class, 'regionalOffice'])->name('contact.regional-office');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::post('/faq/ask', [FaqController::class, 'ask'])
    ->middleware('throttle:5,1')
    ->name('faq.ask');

// News & Events
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{news}', [NewsController::class, 'show'])->whereNumber('news')->name('news.show');
Route::get('/events/{event}', [NewsController::class, 'showEvent'])->whereNumber('event')->name('events.show');

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
Route::get('/find', [FindController::class, 'index'])->name('find');
Route::get('/find/search', [FindController::class, 'search'])
    ->middleware('throttle:30,1')
    ->name('find.search');
Route::get('/find/search-nic', [FindController::class, 'searchByNic'])
    ->middleware('throttle:30,1')
    ->name('find.search-nic');

/*
|--------------------------------------------------------------------------
| Admin Panel  (/admin)
|--------------------------------------------------------------------------
| Create the first admin with:  php artisan admin:create
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Login / logout
    Route::middleware('guest')->group(function () {
        Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->middleware('auth')->name('logout');

    // Protected admin pages
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('news', Admin\NewsController::class)->except('show');
        Route::resource('events', Admin\EventController::class)->except('show');
        Route::resource('faqs', Admin\FaqController::class)->except('show');

        Route::get('/messages', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
        Route::patch('/messages/{message}', [Admin\MessageController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
