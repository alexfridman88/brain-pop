<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreTest extends TestCase
{
    private string $endPoint = 'api/periods';

    /**
     * Test the store method of the class.
     *
     * @return void
     */
    public function test_store(): void
    {
        $teacher = Teacher::factory()->create();
        Sanctum::actingAs($teacher);
        $period = Period::factory()->make();

        $this->postJson($this->endPoint, $period->getAttributes())
            ->assertCreated();
    }

    /**
     * Test the store method of the class when forbidden.
     *
     * @return void
     */
    public function test_store_forbidden(): void
    {
        $student = Student::factory()->make();
        Sanctum::actingAs($student);
        $period = Period::factory()->make();

        $this->postJson($this->endPoint, $period->getAttributes())
            ->assertForbidden();
    }
}
