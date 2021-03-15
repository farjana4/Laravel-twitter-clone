<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'showHome'])->name('home');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'processRegistration'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//below route is using before login
Route::get('email/verify/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//below route is using after login
//Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

//Route::post('email/resend', [VerificationController::class])->name('verification.resend');
