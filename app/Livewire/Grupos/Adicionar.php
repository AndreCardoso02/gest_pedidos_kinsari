<?php

namespace App\Livewire\Grupos;

use Livewire\Component;
use App\Domain\Models\User;
use Livewire\Attributes\Validate;
use App\UseCases\Grupo\AdicionarGrupoUseCase;

class Adicionar extends Component
{
    private $usecase;

    // Propriedades
    #[Validate('required|max:45')]
    public string $nome;

    #[Validate('required|numeric')]
    public string $saldo_permitido;

    #[Validate('required')]
    public string $aprovador_id;

    // Apos a inicializacao do componente
    public function boot(AdicionarGrupoUseCase $usecase)
    {
        $this->usecase = $usecase;
    }

    // Renderizar componente
    public function render()
    {
        return view('livewire.grupos.adicionar', [
            'aprovadores' => User::all() // remover daqui
        ]);
    }

    // Salvar o grupo
    public function salvar()
    {
        $grupo = $this->validate();
        $this->usecase->execute($grupo);
        session()->flash('success', 'Grupo adicionado com sucesso!');
        $this->reset();
        return redirect()->route('grupos.index');
    }

    // Ir para a listagem
    public function irParaListagem()
    {
        return redirect()->route('grupos.index');
    }
}
