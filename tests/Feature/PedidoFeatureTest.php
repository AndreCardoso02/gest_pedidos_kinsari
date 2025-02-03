<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoFeatureTest extends TestCase
{
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
        $aprovador = User::factory()->create();
        $solicitante = User::factory()->create();
        $grupo = Grupo::factory()->create([
            'nome' => 'Grupo 1',
            'saldoPermitido' => 1000,
            'aprovador_id' => $aprovador->id
        ]);

        $pedidos = Pedido::factory()->create([
            'total' => 100,
            'status' => 'novo',
            'dataCriacao' => now(),
            'dataAtualizacao' => now(),
            'solicitante_id' => $solicitante->id,
            'grupo_id' => $grupo->id
        ]);

        // Action
        $response = $this->actingAs($user)->get('/pedidos');
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Sem pedidos encontrados');
        $response->assertSee('Grupo 1');
    }
}
