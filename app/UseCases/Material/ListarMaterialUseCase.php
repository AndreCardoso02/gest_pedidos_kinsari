<?php

namespace App\UseCases\Material;

use App\Domain\Interfaces\IMaterialRepository;

class ListarMaterialUseCase
{
    protected IMaterialRepository $materialRepository;

    public function __construct(IMaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute()
    {
        return $this->materialRepository->listar();
    }
}
