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

// -------------------- ROTAS APENAS PARA UTILIZADORES AUTENTICADOS --------------------
Route::middleware(['auth'])->group(function () {

    // -------------------- ROTAS DE PEDIDOS --------------------
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/create', [PedidoController::class, 'create'])->name('pedidos.create')->middleware('solicitante');
    });
});

