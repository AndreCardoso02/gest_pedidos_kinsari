<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use App\UseCases\Pedido\ListarPedidoUseCase;

class Listagem extends Component
{
    public $pedidos;
    private $listarUseCase;

    public function boot(ListarPedidoUseCase $usecase) {
        $this->listarUseCase = $usecase;
    }

    public function mount() {
        $this->pedidos = $this->listarUseCase->execute();
    }

    public function render()
    {
        return view('livewire.pedidos.listagem');
    }
}
