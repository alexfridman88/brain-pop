<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\LoginTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends CrudControllerAbstract
{
    use LoginTrait;

    protected function controllerMapping(): array
    {
        return [
            'model' => Student::class,
            'resource' => StudentResource::class,
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
            $this->authorize('action-entity', $student);
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
            $this->authorize('action-entity', $student);
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

    public function byTeacher(Teacher $teacher, StudentIndexRequest $request): JsonResponse
    {
        $students = Student::query()
            ->whereHas('periods', fn($periods) => $periods->where('teacher_id', $teacher->id))
            ->when($request->validated()['periodId'] ?? false, fn($students) => $students
                ->whereHas('periods', fn($periods) => $periods->where('id', $request->validated()['periodId'])))
            ->get();

        return response()->json(StudentResource::collection($students));
    }

}
