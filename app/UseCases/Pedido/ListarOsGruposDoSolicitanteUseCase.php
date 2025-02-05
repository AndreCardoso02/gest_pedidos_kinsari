<?php

namespace App\UseCases\Pedido;

use App\Domain\Interfaces\IPedidoRepository;

class ListarOsGruposDoSolicitanteUseCase
{
    protected IPedidoRepository $pedidoRepository;

    public function __construct(IPedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function execute($solicitanteId)
    {
        return $this->pedidoRepository->listarOsGruposDoSolicitante($solicitanteId);
    }
}
