<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Traits\LoginTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class TeacherController extends CrudControllerAbstract
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
            'model' => Teacher::class,
            'resource' => TeacherResource::class,
        ];
    }

    public function store(TeacherStoreRequest $request): JsonResponse
    {
        return $this->storeInstance($request->validated());
    }

    public function show(Teacher $teacher): JsonResponse
    {
        return $this->showInstance($teacher);
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher): JsonResponse
    {
        return $this->updateInstance($request->validated(), $teacher);
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        return $this->destroyInstance($teacher);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('teacher', $request->validated());
    }
}
