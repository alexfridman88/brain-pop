<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentIndexRequest extends FormRequest
{
    /**
     * Authorizes the user.
     *
     * @return bool True if the authorization is successful, false otherwise.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for the given method.
     *
     * @return array The validation rules.
     */
    public function rules(): array
    {
        return [
            'period_id' => ['sometimes', 'numeric'],
            'teacher_id' => ['sometimes', 'numeric'],
        ];
    }
}
