<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Services\LoginService;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends CrudControllerAbstract
{
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

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::guard('students')->attempt($request->validated())) {

            /* @var Student $student */
            $student = Auth::guard('students')->user();
            $student->createToken('authToken');

            return response()->json(new LoginResource($student));
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
