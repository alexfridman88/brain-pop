<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Tests\TestCase;

class StoreTest extends TestCase
{

    private string $endPoint = 'api/students';

    /**
     * Test the "store" method.
     *
     * @return void
     */
    public function test_store(): void
    {
        $model = Student::factory()->make();

        $this->postJson($this->endPoint, $model->getAttributes())
            ->assertCreated();
    }

    /**
     * Test the store method when the request is unprocessable.
     *
     * @return void
     */
    public function test_store_unprocessable(): void
    {
        $model = Student::factory()->make(
            ['username' => null]
        );

        $this->postJson($this->endPoint, $model->getAttributes())
            ->assertUnprocessable();
    }
}
