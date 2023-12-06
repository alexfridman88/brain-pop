<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'full_name' => ['required', 'string'],
            'grade' => ['int', 'required', 'between:0,12']
        ];
    }
}
