<?php

namespace App\Http\Controllers;

use App\Http\Requests\Period\PeriodRequest;
use App\Http\Resources\PeriodResource;
use App\Models\Period;
use App\Models\Teacher;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PeriodController extends CrudControllerAbstract
{
    /**
     * Retrieves the resource mapping for the given method.
     *
     * @return array The resource mapping array containing the 'model' and 'resource' keys.
     */
    protected function controllerMapping(): array
    {
        return [
            'model' => Period::class,
            'resource' => PeriodResource::class
        ];
    }

    /**
     * Store a new period in the database.
     * Only Teachers cant create a new period
     */
    public function store(PeriodRequest $request): JsonResponse
    {
        try {
            $this->authorize('store-period');

            /** @var Teacher $teacher */
            $teacher = Auth::user();
            $period = $teacher->periods()->save(new Period($request->validated()));
            return response()->json($period, Response::HTTP_CREATED);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Period $period): JsonResponse
    {
        try {
            return $this->showInstance($period);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Only creator (teacher) can update period
     */
    public function update(PeriodRequest $request, Period $period): JsonResponse
    {
        try {
            $this->authorize('update-period', $period);
            return $this->updateInstance($request->validated(), $period);
        } catch (AuthorizationException $exception) {
            return response()->json($exception, Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ony creator (teacher) can remove period
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

}
