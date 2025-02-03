<?php

namespace App\UseCases\Grupo;

use App\Domain\Interfaces\IGrupoRepository;

class AdicionarGrupoUseCase
{
    protected IGrupoRepository $grupoRepository;

    public function __construct(IGrupoRepository $grupoRepository)
    {
        $this->grupoRepository = $grupoRepository;
    }

    public function execute(array $data)
    {
        return $this->grupoRepository->adicionar($data);
    }
}
