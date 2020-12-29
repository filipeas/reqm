<?php

namespace Tests\Unit\User;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class UserCascade extends TestCase
{
    /**
     * Excluindo projetos em cascata após excluir conta de usuário.
     * @test
     */
    public function excluindoProjetosDoUsuarioEmCascata()
    {
        $user = User::factory()->create();

        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $project3 = Project::factory()->create();

        $this->assertDatabaseCount('projects', 3);

        $this->actingAs($user)->deleteJson(route('user.delete', ['user' => 1]))
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseCount('projects', 0);
    }
}
