<?php

namespace Tests\Feature\Period;

use App\Models\Period;
use App\Models\Teacher;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{

    private string $endPoint = 'api/periods';

    /**
     * Test the index method
     *
     * @return void
     */
    public function test_index(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->count(10)->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->getJson($this->endPoint)
            ->assertOk();
    }

    /**
     * Test the index method by teacher.
     *
     * @return void
     */
    public function test_index_by_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->count(10)->create(['teacher_id' => $teacher->id]);

        Sanctum::actingAs($teacher);

        $this->json('GET', $this->endPoint, ['teacher_id' => $teacher->id])
            ->assertJson(fn(AssertableJson $json) => $json->each(fn($prop) => $prop->hasAll('id', 'name', 'teacher_id')))
            ->assertOk();
    }


    /**
     * Test the index method when the user is unauthorized.
     *
     * @return void
     */
    public function test_index_unauthorized(): void
    {
        $teacher = Teacher::factory()->create();
        Period::factory()->create(['teacher_id' => $teacher->id]);

        $this->getJson($this->endPoint)
            ->assertUnauthorized();
    }
}
