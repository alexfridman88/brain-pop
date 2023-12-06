<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{

    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'full_name' => $this->faker->name,
            'password' => '123456',
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
