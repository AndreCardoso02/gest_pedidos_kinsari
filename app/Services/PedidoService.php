<?php

namespace App\Services;

use Exception;
use App\Utils\Helpers;
use App\Domain\Models\Pedido;

class PedidoService {

    // prepara o pedido
    public function criarPedido(array $dadosPedido, array $materiais) {

        $user_id = Helpers::getValorSeExiste('solicitante_id', $dadosPedido);
        if ($user_id == null) throw new Exception('Solicitante invalido');

        $grupo_id = Helpers::getValorSeExiste('grupo_id', $dadosPedido);
        if ($grupo_id == null) throw new Exception('Grupo do solicitante invalido');

        return [
            'total' => $this->calcularTotal($materiais),
            'solicitante_id' => $user_id,
            'grupo_id' => $grupo_id,
        ];
    }

    // calcula o total baseando-se nos materiais
    public function calcularTotal(array $materiais)
    {
        return collect($materiais)->sum(fn($material) => $material['preco'] * $material['quantidade']);
    }

    // associa os materias ao pedido
    public function associarMateriaisAoPedido(Pedido $pedido, array $materiais)
    {
        foreach ($materiais as $material) {
            $pedido->materiais()->attach($material['material_id'], [
                'quantidade' => $material['quantidade'],
                'subtotal' => $material['preco'] * $material['quantidade']
            ]);
        }
    }
}
