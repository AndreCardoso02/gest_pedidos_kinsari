<?php

namespace App\UseCases\Grupo;

use App\Domain\Interfaces\IGrupoRepository;

class ListarGrupoUseCase
{
    protected IGrupoRepository $grupoRepository;

    public function __construct(IGrupoRepository $grupoRepository)
    {
        $this->grupoRepository = $grupoRepository;
    }

    public function execute()
    {
        return $this->grupoRepository->listar();
    }
}
