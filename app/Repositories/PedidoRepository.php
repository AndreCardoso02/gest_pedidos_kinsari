<?php

namespace App\Repositories;

use App\Domain\Models\Pedido;
use App\Domain\Enums\StatusPedido;
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

    // Aprovar
    public function aprovarPedido(int $id){
        $pedido = $this->buscarPorId($id);
        $pedido->status = StatusPedido::Aprovado;
        $pedido->save();
        return $pedido;
    }

    // Em revisao
    public function pedidoEmRevisao(int $id){
        $pedido = $this->buscarPorId($id);
        $pedido->status = StatusPedido::EmRevisao;
        $pedido->save();
        return $pedido;
    }

    // Rejeitar
    public function rejeitarPedido(int $id){
        $pedido = $this->buscarPorId($id);
        $pedido->status = StatusPedido::Rejeitado;
        $pedido->save();
        return $pedido;
    }

    // Solicitar alteracao
    public function solicitarAlteracaoDoPedido(int $id){
        $pedido = $this->buscarPorId($id);
        $pedido->status = StatusPedido::AlteracoesSolicitadas;
        $pedido->save();
        return $pedido;
    }
}
