<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/user/logout', [LoginController::class, 'userLogout'])->name('user.logout');

Route::group(['prefix' => 'admin'], function () {
    Route::name('admin.')->group(function () {
        Route::group(['middleware' => 'admin.guest'], function () {

            Route::get('', [AdminController::class, 'loginForm'])->name('login');
            Route::post('/login', [AdminController::class, 'authenticate'])->name('auth');
        });

        Route::group(['middleware' => 'admin.auth'], function () {
//            Route::get('/dashboard',)
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

        })->name('dashboard');

    });
});