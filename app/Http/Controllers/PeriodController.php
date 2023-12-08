<?php

namespace App\Http\Controllers;

use App\Http\Requests\Period\PeriodIndexRequest;
use App\Http\Requests\Period\PeriodStoreRequest;
use App\Http\Requests\StudentListRequest;
use App\Http\Resources\PeriodResource;
use App\Models\Period;
use App\Models\Teacher;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PeriodController extends RepositoryAbstract
{

    /**
     * Set the controller mapping.
     *
     * @return array The array containing the model class and resource class.
     */
    protected function controllerMapping(): array
    {
        return [
            'model' => Period::class,
            'resource' => PeriodResource::class
        ];
    }

    /**
     * Get all periods or filtered periods by params.
     *
     * @param PeriodIndexRequest $request The request object containing the teacher ID.
     * @return JsonResponse The JSON response containing the list of filtered periods or the error message and status code.
     */
    public function index(PeriodIndexRequest $request): JsonResponse
    {
        try {
            $periods = Period::filterByTeacher($request->get('teacher_id'))->get();
            return response()->json(PeriodResource::collection($periods));
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a new period.
     * Only authorized 'teachers' can create a period.
     *
     * @param PeriodStoreRequest $request The request object containing the period data.
     * @return JsonResponse The JSON response containing the stored period data or the error message and status code.
     */
    public function store(PeriodStoreRequest $request): JsonResponse
    {
        try {
            /** @var Teacher $teacher */
            $teacher = Auth::user();
            $period = $teacher->periods()->save(new Period($request->validated()));
            return response()->json($period, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified period.
     *
     * @param Period $period The period instance to be shown.
     *
     * @return JsonResponse The JSON response containing the period data.
     */
    public function show(Period $period): JsonResponse
    {
        try {
            return $this->showInstance($period);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update an existing period in the database.
     * Only authorized users with the 'update-period' can update a period.
     *
     * @param PeriodStoreRequest $request The request object containing the validated data.
     * @param Period $period The period instance to be updated.
     * @return JsonResponse The JSON response indicating the success or failure of the update operation.
     */
    public function update(PeriodStoreRequest $request, Period $period): JsonResponse
    {
        try {
            return $this->updateInstance($request->validated(), $period);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete a period from the database.
     * Only authorized users with the 'delete-period' permission can delete a period.
     *
     * @param Period $period The period to be deleted.
     *
     * @return JsonResponse The JSON response containing the result of the operation.
     */
    public function destroy(Period $period): JsonResponse
    {
        try {
            $this->authorize('delete-period', $period);
            return $this->destroyInstance($period);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Attach students to a period.
     *
     * @param Period $period The period to attach students to
     * @param StudentListRequest $request The request containing the student list
     * @return JsonResponse The JSON response indicating success or failure
     */
    public function attachStudents(Period $period, StudentListRequest $request): JsonResponse
    {
        try {
            $period->students()->sync(collect($request->validated())->pluck('id'));
            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Detach students from a period.
     *
     * @param Period $period The period from which to detach students.
     * @param StudentListRequest $request The request containing the list of students to detach.
     * @return JsonResponse The JSON response with a success message or an error message on failure.
     */
    public function detachStudents(Period $period, StudentListRequest $request): JsonResponse
    {
        try {
            $period->students()->detach(collect($request->validated())->pluck('id'));
            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

}
