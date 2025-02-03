<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Interfaces\IGenericoRepository;

// Classe generica para operacoes de crud
class GenericoRepository implements IGenericoRepository
{
    protected Model $model;

    // constructor
    public function __construct(Model $model) {
        $this->model = $model;
    }

    // Listar
    public function listar()
    {
        return $this->model->all();
    }

    // Buscar por Id
    public function buscarPorId($id)
    {
        return $this->model->findOrFail($id);
    }

    // Adicionar
    public function adicionar(array $data)
    {
        return $this->model->create($data);
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
