<?php

namespace App\Livewire\Pedidos;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\UseCases\Pedido\AtualizarPedidoUseCase;
use App\UseCases\Material\ListarMaterialUseCase;
use App\UseCases\Pedido\BuscarPedidoPorIdUseCase;
use App\UseCases\Pedido\ListarOsGruposDoSolicitanteUseCase;

class EditarPedido extends Component
{
    public $pedido;
    public $materiais;
    public $materiaisAdicionados = [];
    public $quantidades = [];
    public $grupos = [];
    public $totalItens = 0;
    public $mostrarModal = false;

    #[Validate('required')]
    public string $grupo_id;

    protected $useCase;
    protected $listarMaterialUseCase;
    protected $listarGrupoUseCase;
    protected $atualizarPedidoUseCase;

    protected $rules = [
        'materiaisAdicionados.*.quantidade' => 'required|numeric|min:0',
    ];

    // Ao Inicializar o componente, injetamos as dependências
    public function boot(
        BuscarPedidoPorIdUseCase $useCase,
        ListarMaterialUseCase $listarMaterialUseCase,
        ListarOsGruposDoSolicitanteUseCase $listarGrupoUseCase,
        AtualizarPedidoUseCase $atualizarPedidoUseCase)
    {
        $this->useCase = $useCase;
        $this->listarMaterialUseCase = $listarMaterialUseCase;
        $this->listarGrupoUseCase = $listarGrupoUseCase;
        $this->atualizarPedidoUseCase = $atualizarPedidoUseCase;
    }

    // Ao montar o componente, carregamos os materiais e grupos
    public function mount($id)
    {
        $this->pedido = $this->useCase->execute($id);
        $this->materiais = $this->listarMaterialUseCase->execute();
        $this->grupos = $this->listarGrupoUseCase->execute(Auth::user()->id);
    }

    // Renderizar a view
    public function render()
    {
        return view('livewire.pedidos.editar-pedido');
    }

    // adicionar material após validação
    public function adicionarMaterial($id) {
        $quantidade = $this->quantidades[$id] ?? 0;

        if ($quantidade <= 0) {
            session()->flash('error', 'A quantidade deve ser maior que 0');
            return;
        }

        $model = $this->materiais->where('id', $id)->first();

        $material = [
            'material_id' => $id,
            'preco' => $model->preco,
            'quantidade' => $quantidade,
        ];

        // adiciona o material ao array de materiais adicionados, se nao existir se existir atualiza a quantidade
        $this->materiaisAdicionados[$id] = $material;

        session()->flash('success', "Material $model->nome adicionado com quantidade $quantidade");

        // o total de itens é a soma de todas as quantidades
        $this->totalItens = array_sum(array_column($this->materiaisAdicionados, 'quantidade'));
    }

    // atualizar pedido
    public function actualizarPedido() {

        $this->validate();

        if (count($this->materiaisAdicionados) <= 0) { // verifica se foi adicionado algum material
            session()->flash('error', 'Precisa inserir algum material');
            return;
        }

        $dadosPedido = [
            'solicitante_id' => Auth::user()->id,
            'grupo_id' => $this->grupo_id,
        ];

        $this->atualizarPedidoUseCase->execute($this->pedido->id, $dadosPedido, $this->materiaisAdicionados);
        session()->flash('success', 'Pedido actualizado com sucesso');
        $this->reset();
        $this->redirect(route('pedidos'));
    }

    // Metodo para abrir a modal
    public function abrirModal()
    {
        $this->mostrarModal = true;
    }

    // Metodo para fechar a modal
    public function fecharModal()
    {
        $this->mostrarModal = false;
    }
}
