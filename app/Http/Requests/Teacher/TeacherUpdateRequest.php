<?php

namespace App\Http\Requests\Teacher;

use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property-read  Teacher $teacher
 */
class TeacherUpdateRequest extends FormRequest
{
    use TeacherBaseRequestTrait;

    public function authorize(): bool
    {
        return Gate::allows('action-entity', $this->teacher);
    }


    public function rules(): array
    {
        return $this->baseRequest();
    }
}
