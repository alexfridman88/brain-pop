<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private string $endpoint = 'api/students/login';

    public function test_login(): void
    {
        $student = Student::factory()->create();

        $this->postJson('api/students/login', [
            'username' => $student->username,
            'password' => '123456',
        ])->assertStatus(200);
    }

    public function test_login_403(): void
    {
        $student = Student::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $student->username,
            'password' => '123456789',
        ])->assertStatus(403);
    }
}
