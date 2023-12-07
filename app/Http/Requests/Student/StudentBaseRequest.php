<?php

namespace App\Http\Requests\Student;

trait StudentBaseRequest
{
    private function baseRequest(): array
    {
        return
            [
                'full_name' => ['required', 'string'],
                'grade' => ['int', 'required', 'between:0,12']
            ];
    }
}
