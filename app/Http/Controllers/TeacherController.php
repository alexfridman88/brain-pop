<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends CrudControllerAbstract
{

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

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::guard('teachers')->attempt($request->validated())) {

            /* @var Teacher $teacher */
            $teacher = Auth::guard('teachers')->user();
            $teacher->createToken('authToken');

            return response()->json(new LoginResource($teacher));
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
