<?php

namespace App\UseCases\Pedido;

use App\Domain\Interfaces\IPedidoRepository;

class BuscarPedidoPorIdUseCase
{
    protected IPedidoRepository $pedidoRepository;

    public function __construct(IPedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function execute(int $id)
    {
        return $this->pedidoRepository->buscarPorId($id);
    }
}
