<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
use Tests\TestCase;

class StoreTest extends TestCase
{
    private string $endpoint = 'api/teachers';

    /**
     * Test the store method
     *
     * @return void
     */
    public function test_store(): void
    {
        $model = Teacher::factory()->make();

        $this->postJson($this->endpoint, $model->getAttributes())
            ->assertCreated();
    }

    /**
     * Test the store method when the request is unprocessable.
     *
     * @return void
     */
    public function test_store_unprocessable(): void
    {
        $model = Teacher::factory()->make([
            'email' => null
        ]);

        $this->postJson($this->endpoint, $model->getAttributes())
            ->assertUnprocessable();
    }
}
