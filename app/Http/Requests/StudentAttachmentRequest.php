<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentAttachmentRequest extends FormRequest
{
    /**
     * Only Teacher can add a students or Student can add itself to period
     */
    public function authorize(): bool
    {
        $studentIds = collect($this->request->all())->pluck('id');
        if ($studentIds->count() > 1) $allow = Gate::allows('teacher');
        else $allow = Gate::allows('teacher') || Gate::allows('action-entity', Student::query()->whereIn('id', $studentIds)->firstOrFail());
        return $allow;
    }

    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer'],
            '*.grade' => ['required', 'integer', 'between:0,12']
        ];
    }
}
