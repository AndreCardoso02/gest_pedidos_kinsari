<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\App\Domain\Models\MaterialFactory> */
    use HasFactory;

    protected $table = 'materiais';

    protected $fillable = [
        'nome',
        'preco',
    ];

    // Relacionamento com a tabela de pedidos
    public function pedidos()
    {
        // pedidos_has_materiais tem outros atributos além dos ids (quatidade e subtotal)
        return $this->belongsToMany(Pedido::class, 'pedidos_has_materiais')
            ->withPivot('quantidade', 'subtotal');
    }
}
