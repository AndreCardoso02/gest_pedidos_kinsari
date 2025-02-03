<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PedidoController
};

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// -------------------- ROTAS DE PEDIDOS --------------------
Route::view('/pedidos', [PedidoController::class, 'index'])
    ->middleware(['auth'])
    ->name('pedidos.index');
