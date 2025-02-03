<?php

namespace App\Domain\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\Models\Grupo;
use App\Domain\Models\Pedido;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Adicionando explicitamente o factory no model
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    // Relacionamento com a tabela de grupos
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'aprovador_id');
    }

    // Relacionamento com a tabela de pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'solicitante_id');
    }
}
