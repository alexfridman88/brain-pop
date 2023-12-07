<?php

namespace Teacher;

use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    private string $endPoint = 'api/teachers';

    public function test_destroy(): void
    {
        $teacher = Teacher::factory()->create();

        Sanctum::actingAs($teacher);

        $this->deleteJson($this->endPoint .'/' . $teacher->id)
            ->assertOk();
    }

    public function test_destroy_403(): void
    {
        $teacher1 = Teacher::factory()->create();
        $teacher2 = Teacher::factory()->create();

        Sanctum::actingAs($teacher1);

        $this->deleteJson($this->endPoint .'/' . $teacher2->id)
            ->assertForbidden();
    }
}
