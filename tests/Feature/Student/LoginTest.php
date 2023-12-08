<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private string $endpoint = 'api/students/login';

    /**
     * Test the login functionality.
     *
     * @return void
     */
    public function test_login(): void
    {
        $student = Student::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $student->username,
            'password' => '123456',
        ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['full_name', 'token']));
    }

    /**
     * Test the login functionality when login is forbidden.
     *
     * @return void
     */
    public function test_login_forbidden(): void
    {
        $student = Student::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $student->username,
            'password' => '123456789',
        ])->assertForbidden();
    }
}
