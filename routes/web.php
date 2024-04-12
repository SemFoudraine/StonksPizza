<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\beheerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WerknemersController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('index');
});

// web.php of api.php
Route::get('/api/fetch-address', [AddressController::class, 'fetchAddress']);
Route::get('/api/fetch-address', [RegisteredUserController::class, 'fetchAddress']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/menu', [PizzaController::class, 'index'])->name('menu');
Route::get('/bedankt', [PizzaController::class, 'bedankt'])->name('bedankt');




// ------------------------- Role Routes ------------------------- \\
Route::get('/beheer', [BeheerController::class, 'index'])->name('beheer')->middleware('role:medewerker,manager,koerier');
Route::get('/werknemers', [WerknemersController::class, 'index'])->name('werknemers')->middleware('role:manager');

Route::get('/search-users', [UserController::class, 'search'])->name('users.search')->middleware('role:manager');
Route::post('/add-user-to-role', [UserController::class, 'addToRole'])->name('users.add-to-role')->middleware('role:manager');
// web.php
Route::delete('/remove-user-from-role', [WerknemersController::class, 'removeFromRole'])
    ->name('remove.user.from.role')
    ->middleware('role:manager');

require __DIR__ . '/auth.php';
