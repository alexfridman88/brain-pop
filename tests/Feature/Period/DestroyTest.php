<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    private string $endPoint = 'api/periods';

    public function test_destroy(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->deleteJson($this->endPoint .'/'. $period->id)
            ->assertOk();
    }

    public function test_destroy_403(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $teacher2 = Teacher::factory()->create();
        Sanctum::actingAs($teacher2);

        $this->deleteJson($this->endPoint .'/'. $period->id)
            ->assertForbidden();
    }
}
