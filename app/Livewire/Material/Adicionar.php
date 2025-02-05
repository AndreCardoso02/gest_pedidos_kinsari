<?php

namespace App\Livewire\Material;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\UseCases\Material\AdicionarMaterialUseCase;

class Adicionar extends Component
{

    private $usecase;

    // Propriedades
    #[Validate('required|max:45')]
    public string $nome;

    #[Validate('required|numeric')]
    public string $preco;

    // Apos a inicializacao do componente
    public function boot(AdicionarMaterialUseCase $usecase)
    {
        $this->usecase = $usecase;
    }

    // Renderizar componente
    public function render()
    {
        return view('livewire.material.adicionar');
    }

    // Salvar o material
    public function salvar()
    {
        $material = $this->validate();
        $this->usecase->execute($material);
        session()->flash('success', 'Material adicionado com sucesso!');
        $this->reset();
        return redirect()->route('materiais.index');
    }

    // Ir para a listagem
    public function irParaListagem()
    {
        return redirect()->route('materiais.index');
    }
}
