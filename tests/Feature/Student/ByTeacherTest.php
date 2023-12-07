<?php

namespace Student;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ByTeacherTest extends TestCase
{
    private string $endPoint = 'api/students/teacher';

    public function test_index_by_period(): void
    {
        $teacher = Teacher::factory()->create();
        Sanctum::actingAs($teacher);
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $students = Student::factory()->createMany(5);
        $period->students()->sync($students->pluck('id'));

        $this->getJson($this->endPoint . '/'. $teacher->id)
            ->assertOk();
    }

    public function test_index_by_period_to_a_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        Sanctum::actingAs($teacher);
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $students = Student::factory()->createMany(6);
        $period->students()->sync($students->pluck('id'));

        $this->json('GET', $this->endPoint . '/'. $teacher->id, ['periodId' => $period->id])
            ->assertOk();
    }
}
