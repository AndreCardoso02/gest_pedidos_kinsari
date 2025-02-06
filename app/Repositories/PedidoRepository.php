<?php

namespace App\Repositories;

use App\Domain\Models\Grupo;
use App\Domain\Models\Pedido;
use App\Domain\Enums\StatusPedido;
use App\Domain\Interfaces\IPedidoRepository;

class PedidoRepository extends GenericoRepository implements IPedidoRepository
{
    // Listar
    public function listar()
    {
        return Pedido::query()->with(['solicitante'])->get();
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

    // Listar pedidos do solicitante
    public function listarPedidosDoSolicitante(int $solicitanteId) {
        return Pedido::query()->where('solicitante_id', $solicitanteId)->get();
    }

    // seleciona todos os grupos do aprovador e em seguida todos os pedidos dos grupos
    public function listarPedidosDosGruposDoAprovador(int $aprovadorId) {
        $grupos = Grupo::query()->where('aprovador_id', $aprovadorId)->get();
        $gruposIds = $grupos->pluck('id');
        return Pedido::query()
                        ->whereIn('grupo_id', $gruposIds)
                        ->orWhere('solicitante_id', $aprovadorId)
                        ->get();
    }

    // Listar todos os grupos do solicitante
    public function listarOsGruposDoSolicitante(int $solicitanteId){
        return Grupo::query()
        ->whereHas('solicitantes', function ($query) use ($solicitanteId) {
            $query->where('user_id', $solicitanteId);
        })
        ->get();
    }
}
