<?php

namespace App\Livewire\Material;

use Livewire\Component;
use App\UseCases\Material\ListarMaterialUseCase;
use App\UseCases\Material\RemoverMaterialUseCase;

class Listagem extends Component
{
    public $materiais;
    private $usecase;
    private $usecaseRemover;

    // Ijectar a dependencia de listar use ase
    public function boot(
        ListarMaterialUseCase $usecase,
        RemoverMaterialUseCase $usecaseRemover)
    {
        $this->usecase = $usecase;
        $this->usecaseRemover = $usecaseRemover;
    }

    // quando montar o componente
    public function mount() {
        $this->materiais = $this->usecase->execute();
    }

    public function render()
    {
        return view('livewire.material.listagem');
    }

    // excluir o grupo
    public function excluir($id)
    {
        $this->usecaseRemover->execute($id);
        session()->flash('success', 'Material removido com sucesso!');
        $this->mount();
    }

    // ir para editar
    public function editar($id)
    {
        return redirect()->route('materiais.edit', ['id' => $id]);
    }
}
