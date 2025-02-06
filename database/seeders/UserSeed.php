<?php

namespace Database\Seeders;

use App\Domain\Models\User;
use App\Domain\Models\Grupo;
use App\Domain\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@kinsari.com',
            'password' => bcrypt('AAaa123#')
        ]);

        $solicitante = User::create([
            'name' => 'Solicitante',
            'email' => 'solicitante@kinsari.com',
            'password' => bcrypt('AAaa123#')
        ]);

        $aprovador = User::create([
            'name' => 'Aprovador',
            'email' => 'aprovador@kinsari.com',
            'password' => bcrypt('AAaa123#')
        ]);

        $admin->assignRole('admin');
        $solicitante->assignRole('solicitante');
        $aprovador->assignRole('aprovador');

        $grupo = Grupo::create([
            'nome' => 'Default',
            'saldo_permitido' => 1000,
            'aprovador_id' => $aprovador->id
        ]);

        $solicitante->gruposComoSolicitante()->attach($grupo->id);

        $materiais = Material::create([
            'nome' => 'Computador',
            'preco' => 209
        ]);

        $materiais = Material::create([
            'nome' => 'Monitor',
            'preco' => 100
        ]);
    }
}
