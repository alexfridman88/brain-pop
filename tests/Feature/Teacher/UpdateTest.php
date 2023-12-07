<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    private string $endPoint = 'api/teachers';

    public function test_update(): void
    {
        $model = Teacher::factory()->create();
        Sanctum::actingAs($model);
        $this->putJson($this->endPoint . '/' . $model->id, $model->getAttributes())
            ->assertOk();
    }

    public function test_update_403(): void
    {
        $model = Teacher::factory()->create();
        Sanctum::actingAs($model);
        $model2 = Teacher::factory()->create();

        $this->putJson($this->endPoint . '/' . $model2->id, $model->getAttributes())
            ->assertForbidden();
    }
}
