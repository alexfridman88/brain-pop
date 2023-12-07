<?php

namespace Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ByTeacherTest extends TestCase
{

    private string $endPoint = 'api/periods';

    public function test_by_teacher_auth_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint . '/teacher/' . $teacher->id)
            ->assertOk();
    }

    public function test_by_teacher_auth_student(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->create(['teacher_id' => $teacher->id]);

        $student = Student::factory()->create();
        Sanctum::actingAs($student);

        $this->getJson($this->endPoint . '/teacher/' . $teacher->id)
            ->assertOk();
    }

    public function test_by_teacher_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->create(['teacher_id' => $teacher->id]);

        $this->getJson($this->endPoint . '/teacher/' . $teacher->id)
            ->assertUnauthorized();
    }
}
