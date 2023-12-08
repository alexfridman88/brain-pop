<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    private string $endPoint = 'api/teachers';

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update(): void
    {
        $model = Teacher::factory()->create();
        Sanctum::actingAs($model);
        $this->putJson($this->endPoint . '/' . $model->id, $model->getAttributes())
            ->assertOk();
    }

    /**
     * Test the update method when the user is forbidden from updating another teacher's data.
     *
     * @return void
     */
    public function test_update_forbidden(): void
    {
        $model = Teacher::factory()->create();
        Sanctum::actingAs($model);
        $model2 = Teacher::factory()->create();

        $this->putJson($this->endPoint . '/' . $model2->id, $model->getAttributes())
            ->assertForbidden();
    }
}
