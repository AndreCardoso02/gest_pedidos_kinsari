<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PedidoController,
    GrupoController,
    MaterialController,
};

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
        Route::get('/', [PedidoController::class, 'index'])->name('pedidos');
        Route::get('/create', [PedidoController::class, 'create'])->name('pedidos.create')->middleware('solicitante');
    });

    Route::name('grupos.')->prefix('grupos')->group(function () {
        Route::get('/', [GrupoController::class, 'index'])->name('index');
        Route::get('/create', [GrupoController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [GrupoController::class, 'edit'])->name('edit');
        Route::get('/{id}', [GrupoController::class, 'show'])->name('show');
    });

    Route::name('materiais.')->prefix('materiais')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('index');
        Route::get('/create', [MaterialController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('edit');
        Route::get('/{id}', [MaterialController::class, 'show'])->name('show');
    });
});
