<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
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

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/list', [PlayersController::class, 'index']);

Route::prefix('players')->group(function () {
    Route::get('/', [PlayersController::class, 'index'])->name('players.index');
    Route::get('/{id}', [PlayersController::class, 'showDetail'])->name('players.showDetail');
});