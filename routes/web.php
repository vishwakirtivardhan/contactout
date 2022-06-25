<?php

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
    return view('welcome');
});

Auth::routes(); // Laravel Auth Route for Login and sign up.
// Route::post('ValidateLink',[App\Http\Controllers\referralController::class, 'ValidateLink']);
Route::get('home',[App\Http\Controllers\HomeController::class, 'index']);
// Admin - Dashboard Route
Route::get('admin/referrals',[App\Http\Controllers\referralController::class, 'AdminRefferals']);



Route::middleware(['auth'])->group(function () { // Check for user login
    // Dashboard after login and sign up
    Route::get('referrals', [App\Http\Controllers\referralController::class, 'refferalView'])->name('referrals');
    // Ajax route check for email validation
    Route::post('validateEmail',[App\Http\Controllers\referralController::class, 'validateEmail']);
    // Save Email form input box. 
    Route::post('submitForm',[App\Http\Controllers\referralController::class, 'referralsEmailSave']);
});