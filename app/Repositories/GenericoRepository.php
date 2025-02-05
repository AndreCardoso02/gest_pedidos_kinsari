<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Interfaces\IGenericoRepository;

// Classe generica para operacoes de crud
class GenericoRepository implements IGenericoRepository
{
    protected $model;

    // Listar
    public function listar()
    {
        return app($this->model)->all();
    }

    // Buscar por Id
    public function buscarPorId($id)
    {
        return app($this->model)->findOrFail($id);
    }

    // Adicionar
    public function adicionar(array $data)
    {
        return app($this->model)->create($data);
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
