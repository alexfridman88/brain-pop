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

    /**
     * Authorize the user for an action-period or teacher role.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return $this->period
            ? Gate::allows('actions-period', $this->period)
            : Gate::allows('teacher');
    }

    /**
     * Returns an array of rules for validating the input data.
     *
     * @return array The array of validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
