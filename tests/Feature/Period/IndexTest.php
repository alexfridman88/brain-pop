<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{

    private string $endPoint = 'api/periods';

    public function test_index(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->count(10)->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint)
            ->assertOk();
    }

    public function test_index_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->count(10)->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->json('GET', $this->endPoint, ['teacher_id' => $teacher->id])
            ->assertOk();
    }


    public function test_index_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->create(['teacher_id' => $teacher->id]);

        $this->getJson($this->endPoint)
            ->assertUnauthorized();
    }
}
