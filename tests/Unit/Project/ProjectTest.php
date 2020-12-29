<?php

namespace Tests\Unit\Project;

use App\Models\Project as Project;
use App\Models\User;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ProjectTest extends TestCase
{
    /**
     * Cadastrando projeto no sistema.
     * @test
     */
    public function cadastrandoProjeto()
    {
        $user = User::factory()->create();

        $data = [
            'initials' => 'ABC',
            'scope' => 'escopo do projeto',
            'product_limits' => 'limites do produto',
            'client_institution' => 'empresa_do_cliente',
            'developer_institution' => 'FASoft',
            'acronym_definitions' => 'definições de siglas',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'), // data da criação do projeto
            'end_date' => $this->faker->date($format = 'Y-m-d'),
        ];

        $this->actingAs($user)->postJson(route('project.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'user', 'initials', 'scope', 'product_limits', 'client_institution', 'developer_institution', 'acronym_definitions', 'start_date', 'end_date', 'updated_at', 'created_at']);
    }

    /**
     * Cadastrando dois projetos com a mesma sigla.
     * @test
     */
    public function cadastrandoDoisProjetosComMesmaSigla()
    {
        $user = User::factory()->create();

        $data = [
            'initials' => 'ABC',
            'scope' => 'escopo do projeto',
            'product_limits' => 'limites do produto',
            'client_institution' => 'empresa_do_cliente',
            'developer_institution' => 'FASoft',
            'acronym_definitions' => 'definições de siglas',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'), // data da criação do projeto
            'end_date' => $this->faker->date($format = 'Y-m-d'),
        ];

        $this->actingAs($user)->postJson(route('project.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'user', 'initials', 'scope', 'product_limits', 'client_institution', 'developer_institution', 'acronym_definitions', 'start_date', 'end_date', 'updated_at', 'created_at']);

        $this->actingAs($user)->postJson(route('project.store'), $data)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Alterando projeto do sistema.
     * @test
     */
    public function alterandoProjeto()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();

        $data = [
            'id' => 1,
            'initials' => 'ABC',
            'scope' => 'escopo do projeto',
            'product_limits' => 'limites do produto',
            'client_institution' => 'empresa_do_cliente',
            'developer_institution' => 'FASoft',
            'acronym_definitions' => 'definições de siglas',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'), // data da criação do projeto
            'end_date' => $this->faker->date($format = 'Y-m-d'),
        ];

        $this->actingAs($user)->putJson(route('project.update', ['project' => 1]), $data)
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'user', 'initials', 'scope', 'product_limits', 'client_institution', 'developer_institution', 'acronym_definitions', 'start_date', 'end_date', 'updated_at', 'created_at']);
    }

    /**
     * Alterando projeto e colocando sigla de outro projeto do sistema.
     * @test
     */
    public function alterandoProjetoEcolocandoSiglaRepetida()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();
        $project2 = Project::factory()->create();

        $data = [
            'id' => 1,
            'initials' => 'ABC',
            'scope' => 'escopo do projeto',
            'product_limits' => 'limites do produto',
            'client_institution' => 'empresa_do_cliente',
            'developer_institution' => 'FASoft',
            'acronym_definitions' => 'definições de siglas',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'), // data da criação do projeto
            'end_date' => $this->faker->date($format = 'Y-m-d'),
        ];

        $this->actingAs($user)->putJson(route('project.update', ['project' => 1]), $data)
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'user', 'initials', 'scope', 'product_limits', 'client_institution', 'developer_institution', 'acronym_definitions', 'start_date', 'end_date', 'updated_at', 'created_at']);

        $this->actingAs($user)->putJson(route('project.update', ['project' => 1]), $data)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Listar todos os projetos do usuário.
     * @test
     */
    public function listandoProjetos()
    {
        $user = User::factory()->create();

        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $project3 = Project::factory()->create();

        $this->actingAs($user)->getJson(route('project.index'))
            ->assertStatus(200)
            ->assertJsonStructure(['current_page', 'data', 'first_page_url', 'from', 'last_page', 'last_page_url', 'links', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total']);
    }

    /**
     * Listar um projeto do usuário.
     * @test
     */
    public function listandoUmProjeto()
    {
        $user = User::factory()->create();

        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $project3 = Project::factory()->create();

        $this->actingAs($user)->getJson(route('project.show', ['project' => 2]))
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'user', 'initials', 'scope', 'product_limits', 'client_institution', 'developer_institution', 'acronym_definitions', 'start_date', 'end_date', 'updated_at', 'created_at']);
    }

    /**
     * Excluindo projeto do sistema.
     * @test
     */
    public function excluindoProjeto()
    {
        $user = User::factory()->create();

        $project1 = Project::factory()->create();

        $this->actingAs($user)->deleteJson(route('project.destroy', ['project' => 1]))
            ->assertStatus(200);
    }
}
