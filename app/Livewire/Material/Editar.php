<?php

namespace App\Livewire\Material;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\UseCases\Material\AtualizarMaterialUseCase;
use App\UseCases\Material\BuscarMaterialPorIdUseCase;

class Editar extends Component
{
    private $usecase;
    private $usecaseBuscarPorId;

    public $material;

    // Propriedades
    #[Validate('required|max:45')]
    public string $nome;

    #[Validate('required|numeric')]
    public string $preco;

    // Apos a inicializacao do componente
    public function boot(
        AtualizarMaterialUseCase $usecase,
        BuscarMaterialPorIdUseCase $usecaseBuscarPorId)
    {
        $this->usecase = $usecase;
        $this->usecaseBuscarPorId = $usecaseBuscarPorId;
    }

    // Apos a montagem do componente
    public function mount($id)
    {
        $this->material = $this->usecaseBuscarPorId->execute($id);
        $this->fill($this->material);
    }

    // Renderizar componente
    public function render()
    {
        return view('livewire.material.editar');
    }

    // Salvar o material
    public function salvar()
    {
        $dados = $this->validate();
        $this->usecase->execute($this->material->id, $dados);
        session()->flash('success', 'Material atualizado com sucesso!');
        $this->reset();
        return redirect()->route('materiais.index');
    }

    // Ir para a listagem
    public function irParaListagem()
    {
        return redirect()->route('materiais.index');
    }
}
