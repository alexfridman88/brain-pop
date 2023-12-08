<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    private string $endPoint = 'api/students';

    /**
     * Update the student record through an API endpoint.
     *
     * @return void
     */
    public function test_update(): void
    {
        $model = Student::factory()->create();
        Sanctum::actingAs($model);

        $this->putJson($this->endPoint . '/' . $model->id, $model->getAttributes())
            ->assertOk();
    }

    /**
     * Test case for testing the update method when it is forbidden.
     *
     * @return void
     */
    public function test_update_forbidden(): void
    {
        $model = Student::factory()->create();
        Sanctum::actingAs($model);
        $model2 = Student::factory()->create();

        $this->putJson($this->endPoint . '/' . $model2->id, $model->getAttributes())
            ->assertForbidden();
    }
}
