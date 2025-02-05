<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\UseCases\Pedido\ListarPedidoUseCase;
use App\UseCases\Pedido\ListarPedidosDoSolicitanteUseCase;
use App\UseCases\Pedido\ListarPedidosDosGruposDoAprovadorUseCase;

class Listagem extends Component
{
    public $pedidos;
    private $listarUseCase;
    private $listarUseCaseAprovador;
    private $listarUseCaseSolicitante;

    public function boot(
        ListarPedidoUseCase $usecase,
        ListarPedidosDosGruposDoAprovadorUseCase $usecaseAprovador,
        ListarPedidosDoSolicitanteUseCase $usecaseSolicitante) {
        $this->listarUseCase = $usecase;
        $this->listarUseCaseAprovador = $usecaseAprovador;
        $this->listarUseCaseSolicitante = $usecaseSolicitante;
    }

    public function mount() {
        if (Auth::user()->isAprovador()) {
            $this->pedidos = $this->listarUseCaseAprovador->execute(Auth::user()->id);
            return;
        }

        if (Auth::user()->isSolicitante()) {
            $this->pedidos = $this->listarUseCaseSolicitante->execute(Auth::user()->id);
            return;
        }

        if (Auth::user()->isAdmin()) {
            $this->pedidos = $this->listarUseCase->execute();
            return;
        }
    }

    public function render()
    {
        return view('livewire.pedidos.listagem');
    }
}
