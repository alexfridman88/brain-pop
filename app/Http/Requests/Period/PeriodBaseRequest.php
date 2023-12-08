<?php

namespace App\Http\Requests\Period;

use App\Models\Period;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * Store or Update Request
 *
 * @property-read Period $period
 */
class PeriodBaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->period
            ? Gate::allows('actions-period', $this->period)
            : Gate::allows('teacher');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
