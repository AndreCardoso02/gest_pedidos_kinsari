<?php

namespace App\Domain\Interfaces;

interface IPedidoRepository extends IGenericoRepository
{
    // Aqui aplicam-se metodos especificos para a entidade Pedido
    public function aprovarPedido(int $id);
    public function pedidoEmRevisao(int $id);
    public function rejeitarPedido(int $id);
    public function solicitarAlteracaoDoPedido(int $id);

    public function listarPedidosDoSolicitante(int $solicitanteId);
    public function listarPedidosDosGruposDoAprovador(int $aprovadorId);
    public function listarOsGruposDoSolicitante(int $solicitanteId);
}
