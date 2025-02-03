<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Models\{
    User,
    Grupo,
    Pedido
};
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoFeatureTest extends TestCase
{
    // Configuracoes base para os testes
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    /**
     * Testando se utilizadores nao autenticados consegues aceder
     * a rota de pedidos, e redirecionado para o login.
     *
     * @return void
     */
    public function test_utilizador_nao_autenticado_nao_consegue_aceder_a_rota_pedidos_e_redirecionado_para_o_login()
    {
        // Action
        $response = $this->get('/pedidos');
        // Assert
        $response->assertRedirect('/login');
    }

    /**
     * Testando se utilizadores autenticados conseguem aceder
     * a rota de pedidos.
     *
     * @return void
     */
    public function test_utilizador_autenticado_consegue_aceder_a_rota_pedidos() {
        // Arrange
        $user = User::factory()->create();
        // Action
        $response = $this->actingAs($user)->get('/pedidos');
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Sem pedidos encontrados');
    }

    /**
     * Testando se utilizadores autenticados conseguem aceder
     * a rota de pedidos e visualizar os pedidos.
     *
     * @return void
     */
    public function test_utilizador_autenticado_consegue_aceder_a_rota_pedidos_e_visualizar_pedidos() {
        // Arrange
        $solicitante = User::factory()->create();
        $grupo = Grupo::factory()->create();

        $pedidos = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $solicitante->id,
            'grupo_id' => $grupo->id
        ]);

        // Action
        $response = $this->actingAs($solicitante)->get('/pedidos');
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Sem pedidos encontrados');
        $response->assertSee($grupo->nome);
    }

    /**
     * Testando o solicitante consegue adicionar pedidos com materiais.
     */
    public function test_se_o_solicitante_consegue_adicionar_pedidos_com_materiais() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'solicitante']);
        $user->assignRole($role); // Utilizador do tipo solicitante

        $grupo = Grupo::factory()->create();
        $user->solicitante()->create([
            'grupo_id' => $grupo->id
        ]); // tornando o utilizador solicitante

        // Materiais a serem incluidos no pedido
        $materiais = Material::factory()->count(3)->create();

        // Dados do pedido (solicitante e grupo devem ser do utilizador logado)
        $dados = [
            'materiais' => $materiais->pluck('id')->toArray()
        ];

        // Action
        $response = $this->actingAs($user)->post('/pedidos', $dados);

        // Assert: verificar se a resposta esta correcta
        $response->assertStatus(302);

        // Verificar se redirecionou para a listagem de pedidos
        $response->assertRedirect('/pedidos');

        // Verificar se o pedido foi adicionado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'solicitante_id' => $user->id,
            'grupo_id' => $grupo->id
        ]);

        // Verificar se os materiais estao associados ao pedido
        $pedido = Pedido::where('solicitante_id', $user->id)->first();
        $this->assertNotNull($pedido);
        $this->assetCount(3, $pedido->materiais);

        foreach($materiais as $material) {
            $this->assertDatabaseHas('pedido_has_material', [
                'material_id' => $material->id,
                'pedido_id' => $pedido->id
            ]);
        }

        // Verificar se o total do pedido esta correcto
        $total = $materiais->sum('preco');
        $this->assertEquals($total, $pedido->total);
    }
}
