<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    private string $endPoint = 'api/periods';

    public function test_update(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->putJson($this->endPoint . '/' .$period->id, $period->getAttributes())
            ->assertOk();
    }

    public function test_update_403(): void
    {
        $teacher = Teacher::factory()->create();
        $period = Period::factory()->create(['teacher_id' => $teacher->id]);

        $teacher2 = Teacher::factory()->create();
        Sanctum::actingAs($teacher2);

        $this->putJson($this->endPoint . '/' .$period->id, $period->getAttributes())
            ->assertForbidden();
    }
}
