<?php

namespace App\UseCases\Material;

use App\Domain\Interfaces\IMaterialRepository;

class RemoverMaterialPorIdUseCase
{
    protected IMaterialRepository $materialRepository;

    public function __construct(IMaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute(int $id)
    {
        return $this->materialRepository->remover($id);
    }
}
