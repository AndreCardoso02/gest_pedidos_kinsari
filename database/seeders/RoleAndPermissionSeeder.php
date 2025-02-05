<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['solicitante', 'aprovador', 'admin'];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::updateOrCreate(['name' => $role]);
        }
    }
}
