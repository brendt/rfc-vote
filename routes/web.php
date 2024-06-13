<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArgumentCommentsController;
use App\Http\Controllers\CreateArgumentCommentController;
use App\Http\Controllers\DisableEmailOptinController;
use App\Http\Controllers\EnableEmailOptinController;
use App\Http\Controllers\EndRfcController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MailPreviewController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PhpInfoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\PublishRfcController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RfcAdminController;
use App\Http\Controllers\RfcCreateController;
use App\Http\Controllers\RfcDetailController;
use App\Http\Controllers\RfcEditController;
use App\Http\Controllers\RfcMetaImageController;
use App\Http\Controllers\SocialiteCallbackController;
use App\Http\Controllers\SocialiteRedirectController;
use App\Http\Controllers\UserEditController;
use App\Http\Controllers\VerificationRequestsAdminController;
use App\Http\Controllers\ViewMessageController;
use App\Http\Livewire\UserList;
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
Route::get('/rfc/{rfc}', RfcDetailController::class)->name('rfc-detail');
Route::get('/argument/{argument}/comments', ArgumentCommentsController::class);
Route::get('/rfc/{rfc}/meta.png', RfcMetaImageController::class)->middleware('cache:900');
Route::get('/login', LoginController::class)->name('login');
Route::get('/register', RegisterController::class)->name('register');
Route::get('/logout', LogoutController::class);
Route::get('/about', AboutController::class);
Route::get('email/verify/{token}', [ProfileController::class, 'verifyEmail'])->name('email.verify');

Route::middleware(AdminMiddleware::class)->prefix('/admin')->group(function () {
    Route::get('/php-info', PhpInfoController::class);
    Route::get('/rfc', RfcAdminController::class);
    Route::get('/verification-requests', VerificationRequestsAdminController::class);
    Route::get('/rfc/new', [RfcCreateController::class, 'create']);
    Route::post('/rfc/new', [RfcCreateController::class, 'store']);
    Route::get('/rfc/{rfc}', [RfcEditController::class, 'edit']);
    Route::post('/rfc/{rfc}', [RfcEditController::class, 'update']);
    Route::post('/rfc/{rfc}/publish', PublishRfcController::class);
    Route::post('/rfc/{rfc}/end', EndRfcController::class);
    Route::get('/mail-preview', MailPreviewController::class);
    Route::get('/users', UserList::class);
    Route::get('/users/{user:id}', [UserEditController::class, 'edit']);
    Route::post('/users/{user:id}', [UserEditController::class, 'update']);

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/messages', MessagesController::class);
    Route::get('/messages/{message}', ViewMessageController::class);
    Route::get('/email-optin/enable', EnableEmailOptinController::class);
    Route::get('/email-optin/disable', DisableEmailOptinController::class);
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/email', [ProfileController::class, 'updateEmail']);
    Route::post('/profile/request-verification', [ProfileController::class, 'requestVerification']);
    Route::post('/argument/{argument}/comments', CreateArgumentCommentController::class);

    Route::redirect('/dashboard', '/')->name('dashboard');
});

Route::get('/auth/redirect/{driver}', SocialiteRedirectController::class);
Route::get('/auth/callback/{driver}', SocialiteCallbackController::class);

Route::get('/forgot-password', ForgotPasswordController::class);
Route::get('/profile/{user}', PublicProfileController::class);
Route::feeds();
Route::mailPreview();
