<?php

namespace App\Domain\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\Models\Grupo;
use App\Domain\Models\Pedido;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
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
    public function gruposComoAprovador()
    {
        return $this->hasMany(Grupo::class, 'aprovador_id');
    }

    // Relacionamento com a tabela de grupos como solicitantes
    public function gruposComoSolicitante()
    {
        return $this->belongsToMany(Grupo::class, 'solicitantes', 'user_id', 'grupo_id')
        ->as('solicitantes');
    }

    // Relacionamento com a tabela de pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'solicitante_id');
    }

    // Utilizador e solicitante
    public function isSolicitante()
    {
        return $this->hasRole('solicitante');
    }

    // Utilizador e administrador
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }


    // Utilizador e aprovador
    public function isAprovador()
    {
        return $this->hasRole('aprovador');
    }
}
