<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\TransactionsController;
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

Route::view('/','welcome');
Route::view('/login', 'login')->name('login');
Route::post('/auth/login', [AuthenticateController::class,'login'])->name('auth/login');

Route::middleware(['auth:web'])->group(function () {
Route::get('/dashboard', [DashboardController::class,'Dashboard'])->name('dashboard');
Route::get('/deposit', [DashboardController::class,'Deposit'])->name('deposit');
Route::post('/initialize', [TransactionsController::class,'initiateDeposit'])->name('initialize');
});
