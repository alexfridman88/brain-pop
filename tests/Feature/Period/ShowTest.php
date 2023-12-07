<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{
    private string $endPoint = 'api/periods';

    public function test_show_teachers(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint .'/'. $period->id)
            ->assertOk();
    }

    public function test_show_students(): void
    {
        $student = Student::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $student->id]);

        Sanctum::actingAs($student);

        $this->getJson($this->endPoint .'/'. $period->id)
            ->assertOk();
    }

    public function test_show_unauthorized(): void
    {
        $student = Student::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $student->id]);


        $this->getJson($this->endPoint .'/'. $period->id)
            ->assertUnauthorized();
    }
}
