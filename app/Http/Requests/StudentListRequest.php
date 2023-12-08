<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentListRequest extends FormRequest
{
    /**
     * Authorizes the action based on the specified criteria.
     *
     * @return bool Returns a boolean indicating whether the action is authorized or not.
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
            '*.id' => ['integer'],
            '*.grade' => ['integer', 'between:0,12']
        ];
    }
}
