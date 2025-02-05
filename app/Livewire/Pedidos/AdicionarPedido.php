<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\UseCases\Pedido\AdicionarPedidoUseCase;
use App\UseCases\Material\ListarMaterialUseCase;

class AdicionarPedido extends Component
{
    public $materiais;
    public $materiaisAdicionados = [];
    public $quantidades = [];

    protected $listarMaterialUseCase;
    protected $adicionarPedidoUseCase;

    protected $rules = [
        'materiaisAdicionados.*.quantidade' => 'required|numeric|min:0',
    ];

    public function boot(
        ListarMaterialUseCase $listarMaterialUseCase,
        AdicionarPedidoUseCase $adicionarPedidoUseCase)
    {
        $this->listarMaterialUseCase = $listarMaterialUseCase;
        $this->adicionarPedidoUseCase = $adicionarPedidoUseCase;
    }

    public function mount()
    {
        $this->materiais = $this->listarMaterialUseCase->execute();
    }

    public function render()
    {
        return view('livewire.pedidos.adicionar-pedido');
    }

    // adicionar material
    public function adicionarMaterial($id) {
        $quantidade = $this->quantidades[$id] ?? 0;

        if ($quantidade <= 0) {
            session()->flash('error', 'A quantidade deve ser maior que 0');
            return;
        }

        $model = $materiais->where('id', $id)->first();

        $material = [
            'material_id' => $id,
            'preco' => $model->preco,
            'quantidade' => $quantidade,
        ];

        array_push($this->materiaisAdicionados, $material);
        session()->flash('success', "Material ID $materialId adicionado com quantidade $quantidade");
    }

    // adicionar pedido
    public function adicionarPedido() {
        // try {
            $dadosPedido = [
                'solicitante_id' => Auth::user()->id,
                'grupo_id' => Auth::user()->gruposComoSolicitante()->first()->id,
            ];

            $this->adicionarPedidoUseCase->execute($dadosPedido, $this->materiaisAdicionados);
        // } catch (\Throwable $th) {
        //     session()->flash('error', $th->getMessage());
        // }
    }
}
