<?php

namespace App\Livewire\Grupos;

use Livewire\Component;
use App\Domain\Models\User;
use Livewire\Attributes\Validate;
use App\UseCases\Grupo\AtualizarGrupoUseCase;
use App\UseCases\Grupo\BuscarGrupoPorIdUseCase;

class Editar extends Component
{
    private $usecase;
    private $usecaseBuscarPorId;

    public $grupo;

    // Propriedades
    #[Validate('required|max:45')]
    public string $nome;

    #[Validate('required|numeric')]
    public string $saldo_permitido;

    #[Validate('required')]
    public string $aprovador_id;

    // Apos a inicializacao do componente
    public function boot(
        AtualizarGrupoUseCase $usecase,
        BuscarGrupoPorIdUseCase $usecaseBuscarPorId)
    {
        $this->usecase = $usecase;
        $this->usecaseBuscarPorId = $usecaseBuscarPorId;
    }

    // Apos a montagem do componente
    public function mount($id)
    {
        $this->grupo = $this->usecaseBuscarPorId->execute($id);
        $this->fill($this->grupo);
    }

    // Renderizar componente
    public function render()
    {
        return view('livewire.grupos.editar', [
            'aprovadores' => User::all() // remover daqui
        ]);
    }

    // Salvar o grupo
    public function salvar()
    {
        $dados = $this->validate();
        $this->usecase->execute($this->grupo->id, $dados);
        session()->flash('success', 'Grupo atualizado com sucesso!');
        $this->reset();
        return redirect()->route('grupos.index');
    }

    // Ir para a listagem
    public function irParaListagem()
    {
        return redirect()->route('grupos.index');
    }
}
