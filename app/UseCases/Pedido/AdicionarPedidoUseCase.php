<?php

namespace App\UseCases\Pedido;

use App\Services\PedidoService;
use App\Domain\Interfaces\IPedidoRepository;

class AdicionarPedidoUseCase
{
    protected IPedidoRepository $pedidoRepository;
    protected PedidoService $pedidoService;

    public function __construct(IPedidoRepository $pedidoRepository, PedidoService $pedidoService)
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->pedidoService = $pedidoService;
    }

    public function execute(array $dados, array $materiais)
    {
        // Faz todo o tratamento dos dados e as devidas validacoes
        $arrayPedido = $this->pedidoService->criarPedido($dados, $materiais);
        $pedido = $this->pedidoRepository->adicionar($arrayPedido);

        $this->pedidoService->associarMateriaisAoPedido($pedido, $materiais);
        return $pedido;
    }
}
