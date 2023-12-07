<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\LoginTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        try {
            return $this->showInstance($student);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StudentStoreRequest $request): JsonResponse
    {
        try {
            return $this->storeInstance($request->validated());
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(StudentUpdateRequest $request, Student $student): JsonResponse
    {
        try {
            $this->authorize('update-entity', $student);
            return $this->updateInstance($request->validated(), $student);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $this->authorize('destroy-entity', $student);
            return $this->destroyInstance($student);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('student', $request->validated());
    }
}
