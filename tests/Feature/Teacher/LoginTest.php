<?php

namespace Tests\Feature\Teacher;

use App\Models\Teacher;
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
        ])->assertOk();
    }

    public function test_login_403(): void
    {
        $teacher = Teacher::factory()->create();

        $this->postJson($this->endpoint, [
            'username' => $teacher->username,
            'password' => '123456789',
        ])->assertForbidden();
    }
}
