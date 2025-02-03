<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\Grupo;
use App\Domain\Enums\StatusPedido;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    protected $model = \App\Domain\Models\Pedido::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grupo = Grupo::factory()->create();
        return [
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'status' => StatusPedido::getRandomValue(),
            'grupo_id' => $grupo->id,
        ];
    }
}
