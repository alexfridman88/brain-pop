<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    use StudentBaseRequest;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->baseRequest();
    }
}
