<?php

namespace App\Http\Requests\Teacher;

use App\Models\Teacher;
use App\Traits\TeacherBaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property-read  Teacher $teacher
 */
class TeacherUpdateRequest extends FormRequest
{
    use TeacherBaseRequestTrait;

    /**
     * Authorize the current user to perform the action on the entity.
     *
     * @return bool True if the user is allowed to perform the action, false otherwise.
     */
    public function authorize(): bool
    {
        return Gate::allows('action-entity', $this->teacher);
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
