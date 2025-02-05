<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\MaterialRepository;
use Illuminate\Foundation\Testing\WithFaker;
use App\Domain\Interfaces\IMaterialRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected IMaterialRepository $repositorio;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositorio =  app(IMaterialRepository::class);

        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    /**
     * Testa se o repositorio de materiais consegue adicionar um material.
     *
     * @return void
     */
    public function test_repositorio_de_materiais_consegue_adicionar_um_material() {
        // Arrange
        $material = [
            'nome' => 'Material de teste',
            'preco' => 10.00
        ];

        // Action
        $materialAdicionado = $this->repositorio->adicionar($material);

        // Assert
        $this->assertDatabaseHas('materiais', [
            'nome' => $materialAdicionado->nome,
            'preco' => $materialAdicionado->preco
        ]);
    }
}
