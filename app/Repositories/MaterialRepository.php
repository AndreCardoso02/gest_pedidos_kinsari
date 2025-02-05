<?php

namespace App\Repositories;

use App\Domain\Models\Material;
use App\Domain\Interfaces\IMaterialRepository;

class MaterialRepository implements IMaterialRepository
{
    // Listar
    public function listar()
    {
        return Material::all();
    }

    // Buscar por Id
    public function buscarPorId($id)
    {
        return Material::findOrFail($id);
    }

    // Adicionar
    public function adicionar(array $data)
    {
        return Material::create($data);
    }

    // Actualizar
    public function atualizar(array $data, $id)
    {
        $registo = $this->buscarPorId($id);
        $registo->update($data);
        return $registo;
    }

    // Remover
    public function remover($id)
    {
        $registo = $this->buscarPorId($id);
        $registo->delete();
        return true;
    }
}
