<?php

namespace Teacher;

use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{
    private string $endPoint = 'api/teachers';

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index(): void
    {
        $teacher = Teacher::factory()->create();
        Sanctum::actingAs($teacher);
        $this->getJson($this->endPoint)
            ->assertOk();
    }

    /**
     * Test for accessing the index endpoint unauthorized.
     *
     * @return void
     */
    public function test_index_unauthorized(): void
    {
        Teacher::factory()->create();

        $this->getJson($this->endPoint)
            ->assertUnauthorized();
    }
}
