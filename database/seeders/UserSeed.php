<?php

namespace Database\Seeders;

use App\Domain\Models\User;
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
    }
}
