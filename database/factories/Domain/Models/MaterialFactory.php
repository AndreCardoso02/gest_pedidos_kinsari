<?php

namespace Database\Factories\Domain\Models;

use App\Domain\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'preco' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
