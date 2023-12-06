<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
{
    use TeacherBaseRequestTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return $this->baseRequest();
    }
}
