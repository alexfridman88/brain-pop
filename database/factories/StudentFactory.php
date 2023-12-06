<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{

    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => '123456',
            'full_name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'grade' => $this->faker->numberBetween(0, 12),
        ];
    }
}
