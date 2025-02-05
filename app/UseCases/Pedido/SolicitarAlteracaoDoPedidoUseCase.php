<?php

namespace App\UseCases\Pedido;

use App\Domain\Enums\StatusPedido;
use App\Domain\Interfaces\IPedidoRepository;

class SolicitarAlteracaoDoPedidoUseCase
{
    protected IPedidoRepository $pedidoRepository;

    public function __construct(
        IPedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function execute($idPedido)
    {
        $pedido = $this->pedidoRepository->buscarPorId($idPedido); // buscar o pedido
        if (!$pedido) { // Verifica se o pedido existe
            throw new \Exception('Pedido não encontrado');
        }

        // verifica se o pedido ja esta aprovado
        if ($pedido->status == StatusPedido::Aprovado) {
            throw new \Exception('Pedido ja se encontra aprovado, nao pode solicitar mudancas');
        }

        // verifica se o pedido ja esta aprovado
        if ($pedido->status == StatusPedido::AlteracoesSolicitadas) {
            throw new \Exception('Ja foi solicitada a mudanca do pedido');
        }

        return $this->pedidoRepository->solicitarAlteracaoDoPedido($idPedido);
    }
}
