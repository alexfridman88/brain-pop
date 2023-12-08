<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Traits\LoginTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends RepositoryAbstract
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
            'model' => Teacher::class,
            'resource' => TeacherResource::class,
        ];
    }

    /**
     * Get the list of teachers.
     *
     * @return JsonResponse The response containing the list of resources.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->indexInstance();
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a new teacher instance.
     *
     * @param TeacherStoreRequest $request The validated request object.
     *
     * @return JsonResponse The JSON response containing the stored teacher instance.
     *
     * @throws Exception If an error occurs during the storing process.
     */
    public function store(TeacherStoreRequest $request): JsonResponse
    {
        try {
            return $this->storeInstance($request->validated());
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show a teacher instance.
     *
     * @param Teacher $teacher The teacher instance to be shown.
     *
     * @return JsonResponse The JSON response containing the teacher instance details.
     *
     * @throws Exception If an error occurs during the showing process.
     */
    public function show(Teacher $teacher): JsonResponse
    {
        try {
            return $this->showInstance($teacher);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update an existing teacher instance.
     *
     * @param TeacherUpdateRequest $request The validated request object.
     * @param Teacher $teacher The teacher object to be updated.
     *
     * @return JsonResponse The JSON response containing the updated teacher instance.
     *
     * @throws Exception If an error occurs during the updating process.
     */
    public function update(TeacherUpdateRequest $request, Teacher $teacher): JsonResponse
    {
        try {
            return $this->updateInstance($request->validated(), $teacher);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Destroy a teacher instance.
     *
     * @param Teacher $teacher The teacher instance to destroy.
     *
     * @return JsonResponse The JSON response indicating the success of the operation.
     *
     * @throws Exception If an error occurs during the destruction process.
     */
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

    /**
     * Authenticate a teacher and log them in.
     *
     * @param LoginRequest $request The request object containing the validated login data.
     *
     * @return JsonResponse The response containing the authenticated teacher details and access token.
     *
     * @throws Exception If an error occurs while authenticating the teacher.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginBy('teacher', $request->validated());
    }

}
