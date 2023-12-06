<?php

namespace App\Http\Requests\Teacher;

trait TeacherBaseRequestTrait
{
    private function baseRequest(): array
    {
        return [
            'full_name' => 'required|string',
            'email'     => 'required|email'
        ];
    }
}
