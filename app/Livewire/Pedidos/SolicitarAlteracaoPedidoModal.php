<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use App\UseCases\Pedido\SolicitarAlteracaoDoPedidoUseCase;

class SolicitarAlteracaoPedidoModal extends Component
{
    // Controlar a visibilidade do modal
    public $mostarModal = false;
    public $pedido;
    protected $solicitarAlteracaoPedidoUseCase;

    public function boot(
        SolicitarAlteracaoDoPedidoUseCase $solicitarAlteracaoPedidoUseCase)
    {
        $this->solicitarAlteracaoPedidoUseCase = $solicitarAlteracaoPedidoUseCase;
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
        return view('livewire.pedidos.solicitar-alteracao-pedido-modal');
    }

    // Metodo para solicitar alteracao do pedido
    public function solicitarAlteracaoPedido()
    {
        try {
            if (!$this->pedido) {
                session()->flash('error', 'Pedido informado invalido');
            } else {
                $this->solicitarAlteracaoPedidoUseCase->execute($this->pedido->id);
                session()->flash('success', 'Pedido alterado com sucesso');
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
        $this->fecharModal();
        return redirect()->route('pedidos');
    }
}
