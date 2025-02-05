<?php

namespace App\UseCases\Pedido;

use App\Services\PedidoService;
use App\Domain\Enums\StatusPedido;
use App\Domain\Interfaces\IPedidoRepository;

class AtualizarPedidoUseCase
{
    protected IPedidoRepository $pedidoRepository;
    protected PedidoService $pedidoService;

    public function __construct(IPedidoRepository $pedidoRepository, PedidoService $pedidoService)
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->pedidoService = $pedidoService;
    }

    public function execute(int $id, array $dados, array $materiais)
    {
        // Faz todo o tratamento dos dados e as devidas validacoes
        $arrayPedido = $this->pedidoService->criarPedido($dados, $materiais);
        $arrayPedido['status'] = StatusPedido::Novo;
        $pedido = $this->pedidoRepository->atualizar($arrayPedido, $id);
        $this->pedidoService->associarMateriaisAoPedido($pedido, $materiais);
        return $pedido;
    }
}
