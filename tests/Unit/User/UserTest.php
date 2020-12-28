<?php

namespace Tests\Unit\User;

use App\Models\User;
use Faker\Factory;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
    /**
     * Novo usuário no sistema
     * @test
     */
    public function CriandoUmUsuario()
    {
        $data = [
            'name' => 'filipe',
            'email' => 'filipe@gmail.com',
            'password' => '12Baco',
            'password_confirm' => '12Baco',
        ];

        $this->postJson(route('user.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure(['name', 'email', 'updated_at', 'created_at', 'id']);
    }

    /**
     * Usuário com email igual
     * @test
     */
    public function usuarioComEmailIgual()
    {
        $data1 = [
            'name' => 'filipe',
            'email' => 'filipe@gmail.com',
            'password' => '12Baco',
            'password_confirm' => '12Baco',
        ];

        $data2 = [
            'name' => 'filipe',
            'email' => 'filipe@gmail.com',
            'password' => '12Baco',
            'password_confirm' => '12Baco',
        ];

        $this->postJson(route('user.store'), $data1)
            ->assertStatus(201)
            ->assertJsonStructure(['name', 'email', 'updated_at', 'created_at', 'id']);

        $this->postJson(route('user.store'), $data2)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * Editar usuário do sistema 
     * @test
     */
    public function editandoUsuario()
    {
        $user = User::factory()->create();

        $data1 = [
            'name' => 'filipe',
            'email_verify' => 'email@email.com',
        ];

        $this->actingAs($user)->putJson(route('user.update', ['user' => 1]), $data1)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    /**
     * Editar senha de usuário do sistema 
     * @test
     */
    public function editandoSenhaUsuario()
    {
        $user = User::factory()->create();

        $data1 = [
            'email_verify' => 'email@email.com',
            'current_password' => '123456',
            'password' => '123abc',
            'password_confirm' => '123abc',
        ];

        $this->actingAs($user)->putJson(route('user.update.password', ['user' => 1]), $data1)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }

    /**
     * Verificar se usuário existe no sistema
     * @test
     */
    public function verificandoUsuarios()
    {
        $user = User::factory()->create();

        $data1 = [
            'email' => 'email@email.com',
        ];

        $this->actingAs($user)->postJson(route('user.check'), $data1)
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']);
    }

    /**
     * Excluir usuário do sistema
     * @test
     */
    public function excluindoUsuario()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->deleteJson(route('user.delete', ['user' => 1]))
            ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    }
}
