<?php

use App\Http\Controllers\EndRfcController;
use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublishRfcController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RfcAdminController;
use App\Http\Controllers\RfcCreateController;
use App\Http\Controllers\RfcDetailController;
use App\Http\Controllers\RfcEditController;
use App\Http\Controllers\RfcMetaImageController;
use App\Http\Controllers\SocialiteCallbackController;
use App\Http\Controllers\SocialiteRedirectController;
use App\Http\Controllers\StoreArgumentController;
use App\Http\Middleware\AdminMiddleware;
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

Route::get('/', HomeController::class);
Route::get('/rfc/{rfc}', RfcDetailController::class);
Route::get('/rfc/{rfc}/meta.png', RfcMetaImageController::class);
Route::Post('/rfc/{rfc}/argument', StoreArgumentController::class);
Route::get('/login', LoginController::class)->name('login');
Route::get('/register', RegisterController::class)->name('register');
Route::get('/register-pending', fn () => view('register-pending'))->name('register-pending');
Route::get('/logout', LogoutController::class);
Route::get('email/verify/{token}', [ProfileController::class, 'verifyEmail'])->name('email.verify');

Route::middleware(AdminMiddleware::class)->prefix('/admin')->group(function () {
    Route::get('/rfc', RfcAdminController::class);
    Route::get('/rfc/new', [RfcCreateController::class, 'create']);
    Route::post('/rfc/new', [RfcCreateController::class, 'store']);
    Route::get('/rfc/{rfc}', [RfcEditController::class, 'edit']);
    Route::post('/rfc/{rfc}', [RfcEditController::class, 'update']);
    Route::post('/rfc/{rfc}/publish', PublishRfcController::class);
    Route::post('/rfc/{rfc}/end', EndRfcController::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/email', [ProfileController::class, 'updateEmail']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/auth/redirect/{driver}', SocialiteRedirectController::class);
Route::get('/auth/callback/{driver}', SocialiteCallbackController::class);

Route::get('/forgot-password', ForgotPassword::class);
