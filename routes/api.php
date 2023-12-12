<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);
    Route::get('list/ages', [AgeController::class, 'listAges']);
    Route::get('list/cities', [CityController::class, 'listCities']);
    Route::get('types', [TypeController::class, 'index']);
    Route::post('passengers/search', [PassengerController::class, 'search']);
    Route::post('passengers', [PassengerController::class, 'create']);
    Route::post('services', [ServiceController::class, 'create']);
    Route::get('services/{service}', [ServiceController::class, 'generatePDF']);
    Route::post('services/manifest', [ServiceController::class, 'getCheckinManifest']);

    //users
    Route::get('users', [UserController::class, 'index']);
    Route::post('register/user', [UserController::class, 'register']);
    Route::put('update/user/{user}', [UserController::class, 'update']);
    Route::delete('delete/user/{user}', [UserController::class, 'delete']);

    //flights
    Route::get('flights', [FlightController::class, 'index']);
    Route::post('register/flight', [FlightController::class, 'register']);
    Route::post('flights/search', [FlightController::class, 'search']);
    Route::put('update/flight/{flight}', [FlightController::class, 'update']);
    Route::delete('delete/flight/{flight}', [FlightController::class, 'delete']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
