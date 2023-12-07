<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{

    private string $endpoint = 'api/teachers/login';

    public function test_login(): void
    {
        $teacher = Teacher::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $teacher->username,
            'password' => '123456',
        ])->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['full_name', 'token']));
    }

    public function test_login_forbidden(): void
    {
        $teacher = Teacher::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $teacher->username,
            'password' => '123456789',
        ])->assertForbidden();
    }
}
