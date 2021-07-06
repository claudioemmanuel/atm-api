<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        return [
            'name'          => $faker->name,
            'cpf'           => $faker->unique()->cpf(false),
            'birth_date'    => $faker->dateTimeThisCentury->format('Y-m-d'),
        ];
    }
}
