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
}
