<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RfcDetailController;
use App\Http\Controllers\SocialiteCallbackController;
use App\Http\Controllers\SocialiteRedirectController;
use App\Http\Controllers\StoreArgumentController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', HomeController::class);
Route::get('/rfc/{rfc}', RfcDetailController::class);
Route::Post('/rfc/{rfc}/argument', StoreArgumentController::class);
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/auth/redirect/{driver}', SocialiteRedirectController::class);
Route::get('/auth/callback/{driver}', SocialiteCallbackController::class);
