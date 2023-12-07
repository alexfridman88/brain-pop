<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\LoginTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends CrudControllerAbstract
{

    use LoginTrait;

    protected function controllerMapping(): array
    {
        return [
            'model' => Teacher::class,
            'resource' => TeacherResource::class,
        ];
    }

    public function index(): JsonResponse
    {
        try {
            return $this->indexInstance();
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(TeacherStoreRequest $request): JsonResponse
    {
        try {
            return $this->storeInstance($request->validated());
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Teacher $teacher): JsonResponse
    {
        try {
            return $this->showInstance($teacher);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher): JsonResponse
    {
        try {
            $this->authorize('action-entity', $teacher);
            return $this->updateInstance($request->validated(), $teacher);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        try {
            $this->authorize('action-entity', $teacher);
            return $this->destroyInstance($teacher);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('teacher', $request->validated());
    }

}
