<?php

namespace App\UseCases\Pedido;

use App\Domain\Interfaces\IPedidoRepository;

class AdicionarPedidoUseCase
{
    protected IPedidoRepository $pedidoRepository;

    public function __construct(IPedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function execute(array $data)
    {
        return $this->pedidoRepository->adicionar($data);
    }
}
