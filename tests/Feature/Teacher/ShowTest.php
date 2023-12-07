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
            ->assertOk()
            ->assertJson([
                'id' => $teacher->id,
                'full_name' => $teacher->full_name,
                'username' => $teacher->username,
                'email' => $teacher->email
            ]);
    }

    public function test_show_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();

        $this->getJson($this->endPoint . '/' . $teacher->id)
            ->assertUnauthorized();
    }
}
