<?php

namespace App\Repositories;

use App\Domain\Models\Pedido;
use App\Domain\Interfaces\IPedidoRepository;

class PedidoRepository extends GenericoRepository implements IPedidoRepository
{
    public function __construct(Pedido $pedido) {
        parent::__construct($pedido);
    }

    // Aqui adicionamos metodos especificos para o pedido, se necessario
}
