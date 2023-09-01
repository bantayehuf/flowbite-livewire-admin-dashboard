<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;

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


// Fortify routes
Route::group(['middleware' => config('fortify.middleware', ['web'])], base_path('routes/sub/fortify.php'));

// Jetstream routes
Route::group(['middleware' => config('jetstream.middleware', ['web'])], base_path('routes/sub/jetstream.php'));


Route::get('/welcome', function () {
    return view('welcome');
})
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/departments', [DepartmentController::class, 'show'])->name('department.show');
    Route::get('/users', [UserController::class, 'show'])->name('users.show');
    Route::get('/roles', [RoleController::class, 'show'])->name('roles.show');
});
