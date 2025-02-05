<?php

namespace App\UseCases\Material;

use App\Domain\Interfaces\IMaterialRepository;

class AtualizarMaterialUseCase
{
    protected IMaterialRepository $materialRepository;

    public function __construct(IMaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function execute(int $id, array $data)
    {
        return $this->materialRepository->atualizar($id, $data);
    }
}
