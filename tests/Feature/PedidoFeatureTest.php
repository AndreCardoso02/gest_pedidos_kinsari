<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
