<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use App\UseCases\Pedido\AprovarPedidoUseCase;

class AprovarPedidoModal extends Component
{
    // Controlar a visibilidade do modal
    public $mostarModal = false;
    public $pedido;
    protected $aprovarPedidoUseCase;

    public function boot(
        AprovarPedidoUseCase $aprovarPedidoUseCase)
    {
        $this->aprovarPedidoUseCase = $aprovarPedidoUseCase;
    }

    // Metodo para abrir a modal
    public function abrirModal()
    {
        $this->mostarModal = true;
    }

    // Metodo para fechar a modal
    public function fecharModal()
    {
        $this->mostarModal = false;
    }

    public function render()
    {
        return view('livewire.pedidos.aprovar-pedido-modal');
    }

    // Metodo para aprovar o pedido
    public function aprovarPedido()
    {
        try {
            if (!$this->pedido) {
                session()->flash('error', 'Pedido informado invalido');
            } else {
                $this->aprovarPedidoUseCase->execute($this->pedido->id);
                session()->flash('success', 'Pedido aprovado com sucesso');
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
        $this->fecharModal();
        return redirect()->route('pedidos');
    }
}
