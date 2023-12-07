<?php

namespace Tests\Feature\Student;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{
    private string $endPoint = 'api/students';

    public function test_index(): void
    {
        $teacher = Teacher::factory()->create();
        Sanctum::actingAs($teacher);
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $students = Student::factory()->createMany(5);
        $period->students()->sync($students->pluck('id'));

        $this->getJson($this->endPoint)
            ->assertOk();
    }

    public function test_index_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $students = Student::factory()->createMany(6);
        $period->students()->sync($students->pluck('id'));

        $this->getJson($this->endPoint)
            ->assertUnauthorized();
    }
}
