<?php

namespace App\Http\Controllers;

use App\Abstracts\RepositoryAbstract;
use App\Http\Requests\Period\PeriodBaseRequest;
use App\Http\Requests\Period\PeriodIndexRequest;
use App\Http\Requests\StudentAttachmentRequest;
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
     *
     *
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

    /**
     * Get all periods or filtered periods by params.
     * If the request contains a 'teacher_id' parameter,
     * only periods associated with the teacher with the given 'id' are returned.
     *
     * @param PeriodIndexRequest $request
     * @return JsonResponse
     */
    public function index(PeriodIndexRequest $request): JsonResponse
    {
        try {
            $periods = Period::filterByTeacher($request->get('teacher_id'))->get();
            return $this->responseJson(PeriodResource::collection($periods));
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Store a new period.
     * Only authorized 'teachers' can create a period.
     * New period instance is created and associated with the authorized teacher.
     *
     * @param PeriodBaseRequest $request The request object containing the period data.
     * @return JsonResponse The JSON response containing the stored period data or the error message and status code.
     */
    public function store(PeriodBaseRequest $request): JsonResponse
    {
        try {
            /** @var Teacher $teacher */
            $teacher = Auth::user();
            $teacher->periods()->save(new Period($request->validated()));
            return $this->responseOk('success', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->responseError($exception);
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
            return $this->showInstance($period)->responseJson($this->resource);
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Update an existing period in the database.
     * Only authorized users with the 'actions-period' permission
     * (associated teacher) can update a period.
     *
     * @param PeriodBaseRequest $request The request object containing the validated data.
     * @param Period $period The period instance to be updated.
     * @return JsonResponse The JSON response indicating the success or failure of the update operation.
     */
    public function update(PeriodBaseRequest $request, Period $period): JsonResponse
    {
        try {
            return $this->updateInstance($period, $request->validated())->responseOk();
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Delete a period from the database.
     * Only authorized users with the 'actions-period' permission
     * (associated teacher) can delete a period.
     *
     * @param Period $period The period to be deleted.
     *
     * @return JsonResponse The JSON response containing the result of the operation.
     */
    public function destroy(Period $period): JsonResponse
    {
        try {
            $this->authorize('actions-period', $period);
            return $this->destroyInstance($period)->responseOk();
        } catch (AuthorizationException $exception) {
            return $this->responseForbidden($exception);
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Attach students to a period.
     *
     * @param Period $period The period to attach students to
     * @param StudentAttachmentRequest $request The request containing the student list
     * @return JsonResponse The JSON response indicating success or failure
     */
    public function attachStudents(Period $period, StudentAttachmentRequest $request): JsonResponse
    {
        try {
            $period->students()->syncWithoutDetaching(collect($request->validated())->pluck('id'));
            return $this->responseOk();
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Detach students from a period.
     *
     * @param Period $period The period from which to detach students.
     * @param StudentAttachmentRequest $request The request containing the list of students to detach.
     * @return JsonResponse The JSON response with a success message or an error message on failure.
     */
    public function detachStudents(Period $period, StudentAttachmentRequest $request): JsonResponse
    {
        try {
            $period->students()->detach(collect($request->validated())->pluck('id'));
            return $this->responseOk();
        } catch (Exception $exception) {
            return $this->responseError($exception);
        }
    }

}
