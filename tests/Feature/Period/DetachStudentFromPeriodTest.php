<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DetachStudentFromPeriodTest extends TestCase
{

    private string $endPoint = 'api/periods';

    public function test_detach_one_student_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($teacher);

        $period->students()->attach([$student->id]);

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', [$student])
            ->assertOk();
    }

    public function test_detach_many_students_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $students = Student::factory()->createMany(10);

        Sanctum::actingAs($teacher);

        $period->students()->attach($students->pluck('id'));

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', $students->toArray())
            ->assertOk();
    }

    public function test_detach_student_is_self(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $period->students()->attach([$student->id]);

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', [$student])
            ->assertOk();
    }

    public function test_detach_many_students_by_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $students = Student::factory()->createMany(10);

        Sanctum::actingAs($student);

        $period->students()->attach($students->pluck('id'));

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', $students->toArray())
            ->assertForbidden();
    }

    public function test_detach_one_student_by_another_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $student2 = Student::factory()->create();

        Sanctum::actingAs($student);

        $period->students()->attach([$student2->id]);

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', [$student2])
            ->assertForbidden();
    }

    public function test_detach_one_student_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        $period->students()->attach([$student->id]);

        $this->postJson($this->endPoint . '/' . $period->id . '/detach', [$student])
            ->assertUnauthorized();
    }

}
