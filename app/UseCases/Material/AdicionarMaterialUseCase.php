<?php

namespace App\UseCases\Material;

use App\Domain\Interfaces\IMaterialRepository;

class AdicionarMaterialUseCase
{
    protected IMaterialRepository $materialRepository;

    public function __construct(IMaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute(array $data)
    {
        return $this->materialRepository->adicionar($data);
    }
}
