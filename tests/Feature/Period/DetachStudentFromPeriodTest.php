<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DetachStudentFromPeriodTest extends TestCase
{

    private string $endPoint = 'api/periods/detach';

    public function test_detach_many_students_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        Sanctum::actingAs($teacher);

        $students = Student::factory()->createMany(10);

        $period->students()->attach($students->pluck('id'));

        $this->postJson($this->endPoint .'/'. $period->id, $students->toArray())->assertOk();
    }

    public function test_detach_student_is_self(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        Sanctum::actingAs($student);

        $period->students()->attach([$student->id]);

        $this->postJson($this->endPoint .'/'. $period->id, [$student])
            ->assertOk();
    }

    public function test_detach_many_students_by_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $student = Student::factory()->create();
        Sanctum::actingAs($student);

        $students = Student::factory()->createMany(10);
        $period->students()->attach($students->pluck('id'));

        $this->postJson($this->endPoint .'/'. $period->id, $students->toArray())
            ->assertForbidden();
    }


}
