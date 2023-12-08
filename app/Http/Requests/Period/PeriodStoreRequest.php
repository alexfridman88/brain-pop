<?php

namespace App\Http\Requests\Period;

use App\Models\Period;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property-read Period $period
 */
class PeriodStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->period
            ? Gate::allows('update-period', $this->period)
            : Gate::allows('teacher');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
