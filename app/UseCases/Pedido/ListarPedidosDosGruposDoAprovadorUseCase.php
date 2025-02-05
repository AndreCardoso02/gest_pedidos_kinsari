<?php

namespace App\UseCases\Pedido;

use App\Domain\Interfaces\IPedidoRepository;

class ListarPedidosDosGruposDoAprovadorUseCase
{
    protected IPedidoRepository $pedidoRepository;

    public function __construct(IPedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function execute($aprovadorId)
    {
        return $this->pedidoRepository->listarPedidosDosGruposDoAprovador($aprovadorId);
    }
}
