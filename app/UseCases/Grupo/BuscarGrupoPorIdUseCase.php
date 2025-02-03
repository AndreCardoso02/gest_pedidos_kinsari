<?php

namespace App\UseCases\Grupo;

use App\Domain\Interfaces\IGrupoRepository;

class BuscarGrupoPorIdUseCase
{
    protected IGrupoRepository $grupoRepository;

    public function __construct(IGrupoRepository $grupoRepository)
    {
        $this->grupoRepository = $grupoRepository;
    }

    public function execute(int $id)
    {
        return $this->grupoRepository->buscarPorId($id);
    }
}
