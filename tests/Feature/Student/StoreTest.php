<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Tests\TestCase;

class StoreTest extends TestCase
{

    private string $endPoint = 'api/students';

    public function test_store(): void
    {
        $model = Student::factory()->make();

        $this->postJson($this->endPoint, $model->getAttributes())
            ->assertCreated();
    }

    public function test_store_422(): void
    {
        $model = Student::factory()->make(
            ['username' => null]
        );

        $this->postJson($this->endPoint, $model->getAttributes())
            ->assertUnprocessable();
    }
}
