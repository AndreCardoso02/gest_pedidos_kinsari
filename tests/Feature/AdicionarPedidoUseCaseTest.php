<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Domain\Models\User;
use App\Domain\Models\Grupo;
use App\Domain\Models\Pedido;
use App\Domain\Models\Material;
use App\Services\PedidoService;
use App\Repositories\PedidoRepository;
use App\Domain\Interfaces\IPedidoRepository;
use Illuminate\Foundation\Testing\WithFaker;
use App\UseCases\Pedido\AdicionarPedidoUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdicionarPedidoUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected AdicionarPedidoUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        // Instanciar repositório e serviço reais
        $pedidoRepository = new PedidoRepository(); // Substitua por seu repositório concreto
        $pedidoService = new PedidoService(); // Substitua por seu serviço concreto

        $this->useCase = new AdicionarPedidoUseCase($pedidoRepository, $pedidoService);
    }

    public function test_execute_deve_criar_e_adicionar_um_pedido()
    {
        $user = User::factory()->create();
        $grupo = Grupo::factory()->create();

        // Relaciona o usuário com o grupo
        $user->gruposComoSolicitante()->attach($grupo->id);

        // Materiais a serem incluídos no pedido
        $materiais = Material::factory()->count(3)->create();

        $dadosMateriais = $materiais->map(fn ($material) => [
            'material_id' => $material->id,
            'preco' => $material->preco,
            'quantidade' => rand(1, 5)
        ])->toArray();

        $dadosPedido = [
            'solicitante_id' => $user->id,
            'grupo_id' => $grupo->id
        ];

        // Criação do pedido
        $this->useCase->execute($dadosPedido, $dadosMateriais);

        // Verifica se o pedido foi criado no banco
        $this->assertDatabaseHas('pedidos', [
            'solicitante_id' => $user->id,
            'grupo_id' => $grupo->id
        ]);

        // Verificar se os materiais estão associados ao pedido
        $pedido = Pedido::where('solicitante_id', $user->id)->first();
        $this->assertNotNull($pedido);
        $this->assertCount(3, $pedido->materiais);

        foreach ($materiais as $material) {
            $this->assertDatabaseHas('pedidos_has_materiais', [
                'material_id' => $material->id,
                'pedido_id' => $pedido->id
            ]);
        }

        // Verificar se o total do pedido está correto
        $totalEsperado = collect($dadosMateriais)->sum(fn ($item) => $item['preco'] * $item['quantidade']);
        $this->assertEquals($totalEsperado, $pedido->total, '', 0.01); // Tolerância de 0.01
    }
}

