<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
{
    use TeacherBaseRequestTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return $this->baseRequest() + [
            'username'  => 'required|string',
            'password'  => 'required|string|min:6',
        ];
    }
}
