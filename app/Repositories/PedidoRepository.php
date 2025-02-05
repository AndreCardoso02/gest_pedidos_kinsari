<?php

namespace App\Repositories;

use App\Domain\Models\Pedido;
use App\Domain\Interfaces\IPedidoRepository;

class PedidoRepository extends GenericoRepository implements IPedidoRepository
{
    // Listar
    public function listar()
    {
        return Pedido::all();
    }

    // Buscar por Id
    public function buscarPorId($id)
    {
        return Pedido::findOrFail($id);
    }

    // Adicionar
    public function adicionar(array $data)
    {
        return Pedido::create($data);
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
