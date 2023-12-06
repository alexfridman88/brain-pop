<?php

namespace Teacher;

use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{

    private string $endPoint = 'api/teachers';

    public function test_show(): void
    {
        $teacher = Teacher::factory()->create();

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint . '/' . $teacher->id)
            ->assertOk();
    }

    public function test_403(): void
    {
        $teacher = Teacher::factory()->create();

        $this->getJson($this->endPoint . '/' . $teacher->id)
            ->assertUnauthorized();
    }
}
