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
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\Pizzascontroller;


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

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

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

Route::get('/api/test-address', [OrderController::class, 'testApi']);

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');


// ------------------------- Role Routes ------------------------- \\
Route::get('/beheer', [BeheerController::class, 'index'])->name('beheer')->middleware('role:medewerker,manager,koerier');
Route::get('/werknemers', [WerknemersController::class, 'index'])->name('werknemers')->middleware('role:manager');

Route::get('/search-users', [UserController::class, 'search'])->name('users.search')->middleware('role:manager');
Route::post('/add-user-to-role', [UserController::class, 'addToRole'])->name('users.add-to-role')->middleware('role:manager');
// web.php
Route::delete('/remove-user-from-role', [WerknemersController::class, 'removeFromRole'])
    ->name('remove.user.from.role')
    ->middleware('role:manager');

    Route::resource('beheer/ingredient', IngredientController::class)->only(['index', 'store', 'edit', 'update', 'destroy'])->middleware('role:manager');
    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

// Gebruik 'PizzasController' met hoofdletter 'C'
Route::middleware(['auth', 'role:medewerker,manager'])->group(function () {
    Route::get('/beheer/pizzas', [PizzasController::class, 'index'])->name('pizza.index');
    Route::get('/beheer/pizzas/create', [PizzasController::class, 'create'])->name('pizza.create');
    Route::post('/beheer/pizzas', [PizzasController::class, 'store'])->name('pizza.store');
    Route::get('/beheer/pizzas/{pizza}', [PizzasController::class, 'show'])->name('pizza.show');
    Route::get('/beheer/pizzas/{pizza}/edit', [PizzasController::class, 'edit'])->name('pizza.edit');
    Route::put('/beheer/pizzas/{pizza}', [PizzasController::class, 'update'])->name('pizza.update');
    Route::delete('/beheer/pizzas/{pizza}', [PizzasController::class, 'destroy'])->name('pizza.destroy');
});



Route::post('/beheer/werknemers/assign-role', [WerknemersController::class, 'assignRole'])->name('assignRole')->middleware('role:manager');
Route::delete('/beheer/werknemers/remove-role', [WerknemersController::class, 'removeFromRole'])->name('removeFromRole')->middleware('role:manager');

Route::get('/beheer/orders', [OrderController::class, 'beheerIndex'])->name('beheer.index')->middleware('role:medewerker,manager,koerier');
Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update.status')->middleware('role:medewerker,manager,koerier');

require __DIR__ . '/auth.php';
