<?php

namespace App\Http\Requests\Teacher;

use App\Traits\TeacherBaseRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
{
    use TeacherBaseRequestTrait;

    /**
     * Authorizes the user.
     *
     * @return bool Returns true if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the rules for validating the data.
     *
     * @return array The array containing the rules for validation.
     */
    public function rules(): array
    {
        return $this->baseRequest() + [
                'username' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6'],
            ];
    }
}
