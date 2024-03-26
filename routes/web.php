<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\UsersController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/users/login');

Route::prefix('users')->group(function () {
    Route::get('/login', [UsersController::class, 'login'])->name('users.login');
    Route::post('/loginCheck', [UsersController::class, 'loginCheck'])->name('users.loginCheck');
    Route::get('/setting', [UsersController::class, 'settingForm'])->name('users.setting');
    Route::post('/setting', [UsersController::class, 'setting'])->name('users.setting');
});

Route::prefix('players')->group(function () {
    Route::get('/', [PlayersController::class, 'index'])->name('players.index');
    Route::get('/{id}', [PlayersController::class, 'showDetail'])->name('players.showDetail');
    Route::get('/{id}/edit', [PlayersController::class, 'edit'])->name('players.edit');
    Route::put('/{id}/update', [PlayersController::class, 'update'])->name('players.update');
    Route::get('/{id}/delete', [PlayersController::class, 'delete'])->name('players.delete');
});