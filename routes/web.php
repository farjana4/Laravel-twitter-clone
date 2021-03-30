<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TranslatesController;
use App\Http\Controllers\VerificationController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/lang/{locale}', [HomeController::class, 'setLocale'])->name('locale');

Route::get('/home', [HomeController::class, 'showHome'])->name('home');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'processRegistration'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login');

//below route is using before login
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

//FORGOT PASSWORD
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//For logged in user
Route::group(['middleware' => 'auth'], function () {
    //LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'updateProfile']);

    // SETTINGS
    Route::get('/settings', [SettingsController::class, 'showSettingsForm'])->name('settings');
    Route::post('/settings/username', [SettingsController::class, 'updateUsername'])->name('settings.username');
    Route::post('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email');
    Route::post('/settings/phone', [SettingsController::class, 'updatePhoneNumber'])->name('settings.phone');

    //Translates(Farjana Testing)
    Route::get('/translates', [TranslatesController::class, 'showTranslatesForm'])->name('translates');
});
