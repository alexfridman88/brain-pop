<?php

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
