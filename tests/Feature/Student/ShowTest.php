<?php

namespace Student;

use App\Models\Student;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{

    private string $endPoint = 'api/students';

    public function test_show(): void
    {
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->getJson($this->endPoint . '/' . $student->id)
            ->assertOk();
    }

    public function test_403(): void
    {
        $student = Student::factory()->create();

        $this->getJson($this->endPoint . '/' . $student->id)
            ->assertUnauthorized();
    }
}
