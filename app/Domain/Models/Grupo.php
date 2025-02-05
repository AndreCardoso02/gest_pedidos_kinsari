<?php

namespace App\Domain\Models;

use App\Domain\Models\User;
use App\Domain\Models\Pedido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    /** @use HasFactory<\Database\Factories\Domain\Models\GrupoFactory> */
    use HasFactory;

    // definindo os campos preenchiveis
    protected $fillable = [
        'nome',
        'saldo_permitido',
        'aprovador_id'
    ];

    // Relacionamento com User
    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovador_id');
    }

    // Relacionamento com Pedido
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'grupo_id');
    }

    // Relacionamento com a tabela de user como solicitante
    public function userSolicitantes()
    {
        return $this->belongsToMany(User::class, 'solicitantes', 'user_id', 'grupo_id')
        ->as('solicitantes');
    }
}
