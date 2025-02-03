<?php

namespace App\Domain\Enums;

enum StatusPedido: string
{
    case Novo = 'novo';
    case EmRevisao = 'em_revisao';
    case AlteracoesSolicitadas = 'alteracoes_solicitadas';
    case Aprovado = 'aprovado';
    case Rejeitado = 'rejeitado';
}
