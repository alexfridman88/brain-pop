<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentAttachmentRequest extends FormRequest
{

    /**
     * Authorizes the request based on the given conditions.
     * Only Teacher can add a students or Student can add itself to period
     *
     * @return bool Returns true if the request is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        $studentIds = collect($this->request->all())->pluck('id');
        $grades = collect($this->request->all())->pluck('grade');

        if ($studentIds->count() > 1) $allow = Gate::allows('teacher');
        else $allow = Gate::allows('teacher') || Gate::allows('action-entity', Student::query()
                ->whereIn('id', $studentIds)
                ->whereIn('grade', $grades)
                ->firstOrFail('id'));
        return $allow;
    }

    /**
     * Gets the validation rules for a specific data structure.
     *
     * @return array The validation rules for the data structure.
     */
    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer'],
            '*.grade' => ['required', 'integer', 'between:0,12']
        ];
    }
}
