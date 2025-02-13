<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Models\{
    User,
    Grupo,
    Pedido,
    Material
};
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Livewire\Livewire;

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
        $role = Role::create(['name' => 'solicitante']);
        $solicitante->assignRole($role);

        $grupo = Grupo::factory()->create();

        // relaciona o utilizador com o grupo
        $solicitante->gruposComoSolicitante()->attach($grupo->id);

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
        //cria um utilizador com a role solicitante
        $user = User::factory()->create();
        $role = Role::create(['name' => 'solicitante']);
        $user->assignRole($role);

        $grupo = Grupo::factory()->create();

        // relaciona o utilizador com o grupo
        $user->gruposComoSolicitante()->attach($grupo->id);

        // Materiais a serem incluidos no pedido
        $materiais = Material::factory()->count(3)->create();

        // Dados do pedido (solicitante e grupo devem ser do utilizador logado)
        // nos dados do pedido devem ser incluidos os materiais e suas quantidades e precos
        $dadosMateriais = $materiais->map(fn ($material) => [
            'material_id' => $material->id,
            'preco' => $material->preco,
            'quantidade' => rand(1, 5)
        ])->toArray();

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web');

        // Testando o formulario de adicao de pedidos com livewire
        Livewire::test('pedidos.adicionar-pedido', ['grupo_id' => $grupo->id])
            ->set('materiaisAdicionados', $dadosMateriais)
            ->call('adicionarPedido');

        // Verificar se o pedido foi adicionado no banco de dados
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
        $this->assertSame(round($totalEsperado, 2), round($pedido->total, 2)); // Comparando com 2 casas decimais
    }

    /**
     * Testando se os utilizadores que nao sao solicitantes nao conseguem adicionar pedidos.
     */
    public function test_se_os_utilizadores_que_nao_sao_solicitantes_nao_conseguem_adicionar_pedidos() {
        // Arrange
        //cria um utilizador com a role solicitante
        $user = User::factory()->create();
        $role = Role::create(['name' => 'aprovador']);
        $user->assignRole($role);

        // Materiais a serem incluidos no pedido
        $materiais = Material::factory()->count(3)->create();

        // Dados do pedido (solicitante e grupo devem ser do utilizador logado)
        $dadosMateriais = $materiais->map(fn ($material) => [
            'material_id' => $material->id,
            'preco' => $material->preco,
            'quantidade' => rand(1, 5)
        ])->toArray();

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web')->get('/pedidos/create'); // sera redirecionado para a listagem de pedidos

        // Assert
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Acesso negado: você não é um solicitante.');
    }


    /**
     * Testando se os utilizadores aprovadores consegues aprovar pedidos.
     */
    public function test_se_os_utilizadores_aprovadores_conseguem_aprovar_pedidos() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'aprovador']);
        $user->assignRole($role);

        $solicitante = User::factory()->create();
        $grupo = Grupo::create([
            'nome' => 'Grupo 1',
            'saldo_permitido' => 1000,
            'aprovador_id' => $user->id
        ]);

        $pedido = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $solicitante->id,
            'grupo_id' => $grupo->id
        ]);

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web');

        // Testando o formulario de aprovacao de pedidos com livewire
        Livewire::test('pedidos.aprovar-pedido-modal', ['pedido' => $pedido])
            ->call('aprovarPedido');

        // Verificar se o pedido foi aprovado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'aprovado'
        ]);
    }

    /**
     * Testando se os utilizadores que nao sejam aprovadores nao conseguem aprovar pedidos.
     */
    public function test_se_os_utilizadores_nao_aprovadores_nao_conseguem_aprovar_pedidos() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'solicitante']);
        $user->assignRole($role);

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web')->get('/pedidos');

        $response->assertDontSee('Aprovar Pedido');
    }

    /**
     * Testando se os utilizadores aprovadores consegues rejeitar pedidos.
     */
    public function test_se_os_utilizadores_aprovadores_conseguem_rejeitar_pedidos() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'aprovador']);
        $user->assignRole($role);

        $solicitante = User::factory()->create();
        $grupo = Grupo::create([
            'nome' => 'Grupo 1',
            'saldo_permitido' => 1000,
            'aprovador_id' => $user->id
        ]);

        $pedido = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $solicitante->id,
            'grupo_id' => $grupo->id
        ]);

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web');

        // Testando o formulario de aprovacao de pedidos com livewire
        Livewire::test('pedidos.rejeitar-pedido-modal', ['pedido' => $pedido])
            ->call('rejeitarPedido');

        // Verificar se o pedido foi aprovado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'rejeitado'
        ]);
    }


    /**
     * Testando se os utilizadores aprovadores consegues solicitar alteracao pedidos.
     */
    public function test_se_os_utilizadores_aprovadores_conseguem_solicitar_alteracao_dos_pedidos() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'aprovador']);
        $user->assignRole($role);

        $solicitante = User::factory()->create();
        $grupo = Grupo::create([
            'nome' => 'Grupo 1',
            'saldo_permitido' => 1000,
            'aprovador_id' => $user->id
        ]);

        $pedido = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $solicitante->id,
            'grupo_id' => $grupo->id
        ]);

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web');

        // Testando o formulario de aprovacao de pedidos com livewire
        Livewire::test('pedidos.solicitar-alteracao-pedido-modal', ['pedido' => $pedido])
            ->call('solicitarAlteracaoPedido');

        // Verificar se o pedido foi aprovado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'alteracoes_solicitadas'
        ]);
    }

    /**
     * Testando se os utilizadores solicitantes conseguem alterar depois de solicitada alteracao e se o pedido retorna ao estado novo
     */
    public function test_se_os_utilizadores_solicitantes_conseguem_alterar_pedidos_depois_de_solicitada_alteracao() {
        // Arrange
        $user = User::factory()->create();
        $role = Role::create(['name' => 'solicitante']);
        $user->assignRole($role);

        $aprovador = User::factory()->create();
        $grupo = Grupo::create([
            'nome' => 'Grupo 1',
            'saldo_permitido' => 1000,
            'aprovador_id' => $aprovador->id
        ]);

        $pedidosBD = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $user->id,
            'grupo_id' => $grupo->id,
            'status' => 'alteracoes_solicitadas'
        ]);

        // Pedido a ser editado
        $pedido = Pedido::create([
            'total' => 100,
            'data_criacao' => now(),
            'data_atualizacao' => now(),
            'solicitante_id' => $user->id,
            'grupo_id' => $grupo->id,
            'status' => 'alteracoes_solicitadas'
        ]);


        // Materiais a serem incluidos no pedido
        $materiais = Material::factory()->count(3)->create();

        // Dados do pedido (solicitante e grupo devem ser do utilizador logado)
        $dadosMateriais = $materiais->map(fn ($material) => [
            'material_id' => $material->id,
            'preco' => $material->preco,
            'quantidade' => rand(1, 5)
        ])->toArray();

        // Action: simula autenticacao do utilizador
        $response = $this->actingAs($user, 'web');

        // Testando o formulario de aprovacao de pedidos com livewire
        Livewire::test('pedidos.editar-pedido', ['id' => $pedido->id])
            ->set('materiaisAdicionados', $dadosMateriais)
            ->call('atualizarPedido');

        // Verificar se o pedido foi actualizado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'status' => 'novo'
        ]);
    }
}
