<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\LoginTrait;
use Illuminate\Http\JsonResponse;

class StudentController extends CrudControllerAbstract
{
    use LoginTrait;
    /**
     * Retrieves the resource mapping for the given method.
     *
     * @return array The resource mapping array containing the 'model' and 'resource' keys.
     */
    protected function controllerMapping(): array
    {
        return [
            'model' => Student::class,
            'resource' => StudentResource::class,
        ];
    }

    public function show(Student $student): JsonResponse
    {
        return $this->showInstance($student);
    }

    public function store(StudentStoreRequest $request): JsonResponse
    {
        return $this->storeInstance($request->validated());
    }

    public function update(StudentUpdateRequest $request, Student $student): JsonResponse
    {
        return $this->updateInstance($request->validated(), $student);
    }

    public function destroy(Student $student): JsonResponse
    {
        return $this->destroyInstance($student);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('student', $request->validated());
    }
}
