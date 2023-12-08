<?php

namespace App\Http\Requests\Student;

use App\Traits\StudentBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    use StudentBaseRequest;

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
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->baseRequest() + [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
