<?php

namespace App\Livewire\Pedidos;

use App\Models\Pedido;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\UseCases\Pedido\AtualizarPedidoUseCase;
use App\UseCases\Material\ListarMaterialUseCase;
use App\UseCases\Pedido\BuscarPedidoPorIdUseCase;
use Illuminate\Auth\Access\AuthorizationException;

class AtualizarPedido extends Component
{
    public $materiais;
    public $materiaisAdicionados = [];
    public $quantidades = [];
    public $pedidoId;
    public $pedido;

    protected $listarMaterialUseCase;
    protected $atualizarPedidoUseCase;
    protected $buscarPedidoPorIdUseCase;

    protected $rules = [
        'materiaisAdicionados.*.quantidade' => 'required|numeric|min:0',
    ];

    public function boot(
        ListarMaterialUseCase $listarMaterialUseCase,
        BuscarPedidoPorIdUseCase $buscarPedidoPorIdUseCase,
        AtualizarPedidoUseCase $atualizarPedidoUseCase)
    {
        $this->listarMaterialUseCase = $listarMaterialUseCase;
        $this->buscarPedidoPorIdUseCase = $buscarPedidoPorIdUseCase;
        $this->atualizarPedidoUseCase = $atualizarPedidoUseCase;
    }

    public function mount($pedidoId)
    {
        $this->pedidoId = $pedidoId;
        $this->pedido = $this->buscarPedidoPorIdUseCase->execute($pedidoId);
        $this->materiais = $this->listarMaterialUseCase->execute();

        // Preenche os materiais adicionados e quantidades
        foreach ($this->pedido->materiais as $material) {
            $this->materiaisAdicionados[] = [
                'material_id' => $material->id,
                'preco' => $material->pivot->preco,
                'quantidade' => $material->pivot->quantidade,
            ];
            $this->quantidades[$material->id] = $material->pivot->quantidade;
        }
    }

    public function render()
    {
        return view('livewire.pedidos.atualizar-pedido');
    }

    public function adicionarMaterial($id)
    {
        $quantidade = $this->quantidades[$id] ?? 0;

        if ($quantidade <= 0) {
            session()->flash('error', 'A quantidade deve ser maior que 0');
            return;
        }

        $model = $this->materiais->where('id', $id)->first();

        // Atualiza se já existe, ou adiciona
        foreach ($this->materiaisAdicionados as &$item) {
            if ($item['material_id'] == $id) {
                $item['quantidade'] = $quantidade;
                session()->flash('success', "Quantidade do material $model->nome atualizada.");
                return;
            }
        }

        $this->materiaisAdicionados[] = [
            'material_id' => $id,
            'preco' => $model->preco,
            'quantidade' => $quantidade,
        ];

        session()->flash('success', "Material $model->nome adicionado com quantidade $quantidade.");
    }

    public function atualizarPedido()
    {
        $this->atualizarPedidoUseCase->execute($this->pedidoId, $this->pedido->toArray(), $this->materiaisAdicionados);

        session()->flash('success', 'Pedido atualizado com sucesso!');
    }
}
