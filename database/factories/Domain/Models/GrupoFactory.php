<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Grupo>
 */
class GrupoFactory extends Factory
{
    protected $model = \App\Domain\Models\Grupo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'nome' => $this->faker->name(),
            'saldo_permitido' => $this->faker->randomFloat(2, 0, 1000),
            'aprovador_id' => $user->id,
        ];
    }
}
