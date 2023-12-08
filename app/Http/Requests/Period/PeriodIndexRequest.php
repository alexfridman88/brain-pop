<?php

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;

class PeriodIndexRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => ['sometimes', 'numeric']
        ];
    }
}
