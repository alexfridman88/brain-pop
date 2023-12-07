<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    private string $endPoint = 'api/students';

    public function test_update(): void
    {
        $model = Student::factory()->create();
        Sanctum::actingAs($model);
        $this->putJson($this->endPoint . '/' . $model->id, $model->getAttributes())
            ->assertOk();
    }

    public function test_update_forbidden(): void
    {
        $model = Student::factory()->create();
        Sanctum::actingAs($model);
        $model2 = Student::factory()->create();

        $this->putJson($this->endPoint . '/' . $model2->id, $model->getAttributes())
            ->assertForbidden();
    }
}
