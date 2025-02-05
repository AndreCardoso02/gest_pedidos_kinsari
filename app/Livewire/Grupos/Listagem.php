<?php

namespace App\Livewire\Grupos;

use Livewire\Component;
use App\UseCases\Grupo\ListarGrupoUseCase;
use App\UseCases\Grupo\RemoverGrupoUseCase;

class Listagem extends Component
{
    public $grupos;
    private $usecase;
    private $usecaseRemover;

    // Ijectar a dependencia de listar use ase
    public function boot(
        ListarGrupoUseCase $usecase,
        RemoverGrupoUseCase $usecaseRemover)
    {
        $this->usecase = $usecase;
        $this->usecaseRemover = $usecaseRemover;
    }

    // quando montar o componente
    public function mount() {
        $this->grupos = $this->usecase->execute();
    }

    public function render()
    {
        return view('livewire.grupos.listagem');
    }

    // excluir o grupo
    public function excluir($id)
    {
        $this->usecaseRemover->execute($id);
        session()->flash('success', 'Grupo removido com sucesso!');
        $this->mount();
    }

    // ir para editar
    public function editar($id)
    {
        return redirect()->route('grupos.edit', ['id' => $id]);
    }
}
