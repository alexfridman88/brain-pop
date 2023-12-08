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

    /**
     * Test detaching one student from a period by a teacher.
     *
     * @return void
     */
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

    /**
     * This method tests the functionality of detaching multiple students from a teacher's period.
     *
     * @return void
     */
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

    /**
     * This method tests the functionality of detaching a student from their own period.
     *
     * @return void
     */
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

    /**
     * Test detach many students by student forbidden.
     *
     * This method is used to test the scenario where a student tries to detach multiple students from a period,
     * but is forbidden to do so.
     *
     * @return void
     */
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

    /**
     * Test detach one student by another student forbidden.
     *
     * This method is used to test the scenario where a student tries to detach another student from a period,
     * but is forbidden to do so.
     *
     * @return void
     */
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

    /**
     * Test detach one student unauthorized.
     *
     * This method is used to test the scenario where a user tries to detach a single student from a period,
     * but is unauthorized to do so.
     *
     * @return void
     */
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
