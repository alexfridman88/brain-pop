<?php

namespace App\Http\Requests\Student;

use App\Models\Student;
use App\Traits\StudentBaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/** @property-read Student $student */
class StudentUpdateRequest extends FormRequest
{
    use StudentBaseRequest;

    /**
     * Authorize the current user to perform the action on the entity.
     *
     * @return bool True if the user is allowed to perform the action, false otherwise.
     */
    public function authorize(): bool
    {
        return Gate::allows('action-entity', $this->student);
    }

    /**
     * Get the rules for validating the data.
     *
     * @return array The array containing the rules for validation.
     */
    public function rules(): array
    {
        return $this->baseRequest();
    }
}
