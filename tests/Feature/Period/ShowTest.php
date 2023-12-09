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

    /**
     * Test the "show period as teacher" functionality.
     *
     * @return void
     */
    public function test_show_period_as_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint . '/' . $period->id)
            ->assertOk();
    }

    /**
     * Test the "show period as student" functionality.
     *
     * @return void
     */
    public function test_show_period_as_student(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->getJson($this->endPoint . '/' . $period->id)
            ->assertJson([
                'id' => $period->id,
                'name' => $period->name,
                'teacher_id' => $period->teacher_id
            ])
            ->assertOk();
    }

    /**
     * Test the "show unauthorized" functionality.
     *
     * @return void
     */
    public function test_show_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $this->getJson($this->endPoint . '/' . $period->id)
            ->assertUnauthorized();
    }
}
