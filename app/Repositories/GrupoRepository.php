<?php

namespace App\Repositories;

use App\Domain\Models\Grupo;
use App\Domain\Interfaces\IGrupoRepository;

class GrupoRepository extends GenericoRepository implements IGrupoRepository
{
    // Listar
    public function listar()
    {
        return Grupo::query()->with(['aprovador'])->get();
    }

    // Buscar por Id
    public function buscarPorId($id)
    {
        return Grupo::findOrFail($id);
    }

    // Adicionar
    public function adicionar(array $data)
    {
        return Grupo::create($data);
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
