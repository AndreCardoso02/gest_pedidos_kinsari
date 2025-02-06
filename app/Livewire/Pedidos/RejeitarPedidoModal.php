<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use App\UseCases\Pedido\RejeitarPedidoUseCase;

class RejeitarPedidoModal extends Component
{
    // Controlar a visibilidade do modal
    public $mostarModal = false;
    public $pedido;
    protected $rejeitarPedidoUseCase;

    public function boot(
        RejeitarPedidoUseCase $rejeitarPedidoUseCase)
    {
        $this->rejeitarPedidoUseCase = $rejeitarPedidoUseCase;
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
        return view('livewire.pedidos.rejeitar-pedido-modal');
    }

    // Metodo para rejeitar o pedido
    public function rejeitarPedido()
    {
        try {
            if (!$this->pedido) {
                session()->flash('error', 'Pedido informado invalido');
            } else {
                $this->rejeitarPedidoUseCase->execute($this->pedido->id);
                session()->flash('success', 'Pedido rejeitado com sucesso');
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
        $this->fecharModal();
        return redirect()->route('pedidos');
    }
}
