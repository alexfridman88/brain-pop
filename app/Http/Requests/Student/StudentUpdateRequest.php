<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentUpdateRequest extends FormRequest
{
    use StudentBaseRequest;

    public function authorize(): bool
    {
        return Gate::allows('action-entity');
    }

    public function rules(): array
    {
        return $this->baseRequest();
    }
}
