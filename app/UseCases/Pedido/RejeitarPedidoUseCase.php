<?php

namespace App\UseCases\Pedido;

use App\Domain\Interfaces\IPedidoRepository;

class RejeitarPedidoUseCase
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
        if ($pedido->status == StatusPedido::Rejeitado) {
            throw new \Exception('Pedido ja se encontra rejeitado');
        }

        return $this->pedidoRepository->rejeitarPedido($idPedido);
    }
}
