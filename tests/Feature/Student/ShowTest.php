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
        /** @var Student $student */
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->getJson($this->endPoint . '/' . $student->id)
            ->assertOk()
            ->assertJson([
                'id' => $student->id,
                'username' => $student->username,
                'full_name' => $student->full_name,
                'grade' => $student->grade
            ]);
    }

    public function test_show_unauthorized(): void
    {
        $student = Student::factory()->create();

        $this->getJson($this->endPoint . '/' . $student->id)
            ->assertUnauthorized();
    }
}
