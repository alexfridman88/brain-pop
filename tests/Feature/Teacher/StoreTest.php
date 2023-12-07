<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
use Tests\TestCase;

class StoreTest extends TestCase
{
    private string $endpoint = 'api/teachers';

    public function test_store(): void
    {
        $model = Teacher::factory()->make();

        $this->postJson($this->endpoint, $model->getAttributes())
            ->assertCreated();
    }

    public function test_store_unprocessable(): void
    {
        $model = Teacher::factory()->make([
            'email' => null
        ]);

        $this->postJson($this->endpoint, $model->getAttributes())
            ->assertUnprocessable();
    }
}
