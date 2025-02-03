<?php

namespace App\Domain\Models;

use App\Domain\Models\User;
use App\Domain\Models\Grupo;
use App\Domain\Enums\StatusPedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\Domain\Models\PedidoFactory> */
    use HasFactory;

    // definindo os campos preenchiveis
    protected $fillable = [
        'total',
        'status',
        'data_atualizacao',
        'solicitante_id',
        'grupo_id'
    ];

    // convertendo os atributos status em enum
    protected $casts = [
        'status' => StatusPedido::class
    ];

    // Desabilita o timestamps
    public $timestamps = false;

    // Relacionamento com solicitante
    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    // Relacionamento com grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
