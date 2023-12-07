<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    private string $endPoint = 'api/students';

    public function test_destroy(): void
    {
        $student = Student::factory()->create();

        Sanctum::actingAs($student);

        $this->deleteJson($this->endPoint .'/' . $student->id)
            ->assertOk();
    }

    public function test_destroy_forbidden(): void
    {
        $student1 = Student::factory()->create();
        $student2 = Student::factory()->create();

        Sanctum::actingAs($student1);

        $this->deleteJson($this->endPoint .'/' . $student2->id)
            ->assertForbidden();
    }
}
