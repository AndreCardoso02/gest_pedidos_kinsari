<?php

namespace App\UseCases\Pedido;

use App\Domain\Enums\StatusPedido;
use App\Domain\Interfaces\IGrupoRepository;
use App\Domain\Interfaces\IPedidoRepository;

class AprovarPedidoUseCase
{
    protected IPedidoRepository $pedidoRepository;
    protected IGrupoRepository $grupoRepository;

    public function __construct(
        IPedidoRepository $pedidoRepository,
        IGrupoRepository $grupoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->grupoRepository = $grupoRepository;
    }

    public function execute($idPedido)
    {
        $pedido = $this->pedidoRepository->buscarPorId($idPedido); // buscar o pedido
        if (!$pedido) { // Verifica se o pedido existe
            throw new \Exception('Pedido não encontrado');
        }

        $grupo = $this->grupoRepository->buscarPorId($pedido->grupo_id);
        if (!$grupo) { // Verifica se o grupo existe
            throw new \Exception('Grupo não encontrado');
        }

        // verifica se o valor do pedido é maior que o limite do grupo
        if ($pedido->total > $grupo->saldo_permitido) {
            throw new \Exception('Valor do pedido e maior que o limite do grupo');
        }

        // verifica se o pedido ja esta aprovado
        if ($pedido->status == StatusPedido::Aprovado) {
            throw new \Exception('Pedido ja se encontra aprovado');
        }

        return $this->pedidoRepository->aprovarPedido($idPedido);
    }
}
