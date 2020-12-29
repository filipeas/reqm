<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user' => 1,
            'initials' => 'iniciais',
            'scope' => 'escopo do projeto',
            'product_limits' => 'limites do produto',
            'client_institution' => 'empresa_do_cliente',
            'developer_institution' => 'FASoft',
            'acronym_definitions' => 'definições de siglas',
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'), // data da criação do projeto
            'end_date' => $this->faker->date($format = 'Y-m-d'),
        ];
    }
}
