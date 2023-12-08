<?php

namespace App\Http\Requests\Student;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/** @property-read Student $student */
class StudentUpdateRequest extends FormRequest
{
    use StudentBaseRequest;

    public function authorize(): bool
    {
        return Gate::allows('action-entity', $this->student);
    }

    public function rules(): array
    {
        return $this->baseRequest();
    }
}
