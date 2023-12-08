<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttachStudentToPeriodTest extends TestCase
{

    private string $endPoint = 'api/periods/attach';

    public function test_attach_one_student_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($teacher);

        $this->postJson($this->endPoint .'/'. $period->id, [$student->id])
            ->assertOk();
    }

    public function test_attach_many_students_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $students = Student::factory()->createMany(10)->toArray();

        Sanctum::actingAs($teacher);

        $this->postJson($this->endPoint .'/'. $period->id, $students)
            ->assertOk();
    }

    public function test_attach_student_is_self(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint .'/'. $period->id, [$student])
            ->assertOk();
    }

    public function test_attach_many_students_by_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $students = Student::factory()->createMany(2);

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint .'/'. $period->id, $students->toArray())
            ->assertForbidden();
    }

    public function test_attach_one_student_by_another_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $student2 = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint .'/'. $period->id, [$student2])
            ->assertForbidden();
    }

    public function test_attach_one_student_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        $this->postJson($this->endPoint .'/'. $period->id, [$student->id])
            ->assertUnauthorized();
    }

}
