<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    use StudentBaseRequest;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->baseRequest() + [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
