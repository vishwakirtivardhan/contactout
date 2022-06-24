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

Auth::routes();
Route::post('ValidateLink',[App\Http\Controllers\referralController::class, 'ValidateLink']);
Route::get('home',[App\Http\Controllers\HomeController::class, 'index']);
Route::get('admin/referrals',[App\Http\Controllers\referralController::class, 'AdminRefferals']);



// Route::get('referrals', [App\Http\Controllers\referralController::class, 'refferalView'])->name('referrals');
// Route::post('validateEmail',[App\Http\Controllers\referralController::class, 'validateEmail']);
// Route::post('submitForm',[App\Http\Controllers\referralController::class, 'referralsEmailSave']);
// Route::get('admin/referrals',[App\Http\Controllers\referralController::class, 'AdminRefferals']);

Route::middleware(['auth'])->group(function () {
    Route::get('referrals', [App\Http\Controllers\referralController::class, 'refferalView'])->name('referrals');
    Route::post('validateEmail',[App\Http\Controllers\referralController::class, 'validateEmail']);
    Route::post('submitForm',[App\Http\Controllers\referralController::class, 'referralsEmailSave']);
});