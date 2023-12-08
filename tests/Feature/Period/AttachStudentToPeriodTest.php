<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttachStudentToPeriodTest extends TestCase
{

    private string $endPoint = 'api/periods';

    /**
     * Test attaching one student by a teacher.
     *
     * @return void
     */
    public function test_attach_one_student_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($teacher);

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', [$student])
            ->assertOk();
    }

    /**
     * Test attaching many students by a teacher.
     *
     * @return void
     */
    public function test_attach_many_students_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $students = Student::factory()->createMany(10)->toArray();

        Sanctum::actingAs($teacher);

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', $students)
            ->assertOk();
    }

    /**
     * Test attaching a student to a period by the student themselves.
     *
     * @return void
     */
    public function test_attach_student_its_self(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', [$student])
            ->assertOk();
    }

    /**
     * Test attaching multiple students to a period by a student, which should be forbidden.
     *
     * @return void
     */
    public function test_attach_many_students_by_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $students = Student::factory()->createMany(2);

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', $students->toArray())
            ->assertForbidden();
    }

    /**
     * Test that it is forbidden for one student to attach another student to a period.
     *
     * @return void
     */
    public function test_attach_one_student_by_another_student_forbidden(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();
        $student2 = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', [$student2])
            ->assertForbidden();
    }

    /**
     * Test attaching one student to a period without authorization.
     *
     * @return void
     */
    public function test_attach_one_student_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        $this->postJson($this->endPoint . '/' . $period->id . '/attach', [$student->id])
            ->assertUnauthorized();
    }

}
