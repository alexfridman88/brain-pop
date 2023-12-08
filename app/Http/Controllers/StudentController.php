<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\LoginTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class StudentController extends RepositoryAbstract
{
    use LoginTrait;

    /**
     * Set the controller mapping.
     *
     * @return array The array containing the model class and resource class.
     */
    protected function controllerMapping(): array
    {
        return [
            'model' => Student::class,
            'resource' => StudentResource::class,
        ];
    }

    /**
     * Get all students or filtering students by params.
     *
     * @param StudentIndexRequest $request The request object containing the filtering parameters.
     *
     * @return JsonResponse Returns a JSON response containing the list of students.
     */
    public function index(StudentIndexRequest $request): JsonResponse
    {
        try {
            $students = Student::filterByTeacher($request->get('teacher_id'))
                ->filterByPeriod($request->get('period_id'))
                ->get();
            return $this->responseJson(StudentResource::collection($students));
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Retrieve a JSON response for a student.
     *
     * @param Student $student The student to retrieve the response for.
     *
     * @return JsonResponse The JSON response containing the student information.
     */
    public function show(Student $student): JsonResponse
    {
        try {
            return $this->showInstance($student);
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Store a new student record in the database.
     *
     * @param StudentStoreRequest $request The request object containing the validated data.
     *
     * @return JsonResponse The response containing the student record that was stored.
     *
     * @throws Exception If an error occurs while storing the student record.
     */
    public function store(StudentStoreRequest $request): JsonResponse
    {
        try {
            return $this->storeInstance($request->validated());
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }


    /**
     * Update an existing student record in the database.
     *
     * @param StudentUpdateRequest $request The request object containing the validated data.
     * @param Student $student The student record to be updated.
     *
     * @return JsonResponse The response containing the updated student record.
     *
     * @throws Exception If an error occurs while updating the student record.
     */
    public function update(StudentUpdateRequest $request, Student $student): JsonResponse
    {
        try {
            return $this->updateInstance($request->validated(), $student);
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Delete a student record from the database.
     *
     * @param Student $student The student object to be deleted.
     *
     * @return JsonResponse The response indicating success or failure of the deletion.
     *
     * @throws Exception If an error occurs while deleting the student record.
     */
    public function destroy(Student $student): JsonResponse
    {
        try {
            $this->authorize('action-entity', $student);
            return $this->destroyInstance($student);
        } catch (AuthorizationException $exception) {
            return $this->responseForbidden($exception);
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Authenticate a student and log them in.
     *
     * @param LoginRequest $request The request object containing the validated login data.
     *
     * @return JsonResponse The response containing the authenticated student details and access token.
     *
     * @throws Exception If an error occurs while authenticating the student.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('student', $request->validated());
    }

}
