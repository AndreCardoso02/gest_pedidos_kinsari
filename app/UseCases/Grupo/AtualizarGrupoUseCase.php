<?php

namespace App\UseCases\Grupo;

use App\Domain\Interfaces\IGrupoRepository;

class AtualizarGrupoUseCase
{
    protected IGrupoRepository $grupoRepository;

    public function __construct(IGrupoRepository $grupoRepository)
    {
        $this->grupoRepository = $grupoRepository;
    }

    public function execute(int $id, array $data)
    {
        return $this->grupoRepository->atualizar($id, $data);
    }
}
