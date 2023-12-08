<?php

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;

class PeriodIndexRequest extends FormRequest
{

    /**
     * Authorizes the user based on certain conditions.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
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
