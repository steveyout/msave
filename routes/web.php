<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminActionsController;
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
Route::get('/logout', [AuthenticateController::class,'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {
Route::get('/dashboard', [DashboardController::class,'Dashboard'])->name('dashboard');
Route::get('/deposit', [DashboardController::class,'Deposit'])->name('deposit');
Route::post('/initialize', [TransactionsController::class,'initiateDeposit'])->name('initialize');
Route::post('/paymentresponse',[TransactionsController::class,'paymentResponse']);

//admin
Route::get('/admin/dashboard', [AdminController::class,'Dashboard'])->name('admin/dashboard');
Route::get('/admin/users', [AdminController::class,'Users'])->name('admin/users');
Route::post('/admin/add', [AdminActionsController::class,'addUer'])->name('admin/add');
Route::post('/admin/delete', [AdminActionsController::class,'deleteUser'])->name('admin/delete');
Route::post('/admin/activate', [AdminActionsController::class,'activateUser'])->name('admin/activate');
Route::post('/admin/generate', [AdminActionsController::class,'generateUsers'])->name('admin/generate');
Route::post('/admin/simulate', [AdminActionsController::class,'simulateTransactions'])->name('admin/simulate');
});
