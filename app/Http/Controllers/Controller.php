<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Success response
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function responseOk(string $message = 'success', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code);
    }

    /**
     * Success Json response
     *
     * @param Collection|AnonymousResourceCollection|JsonResource $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseJson(Collection|AnonymousResourceCollection|JsonResource $data, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Error response
     *
     * @param Exception $exception
     * @param int $code
     * @return JsonResponse
     */
    public function responseError(Exception $exception, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([$exception], $code);
    }

    /**
     * Forbidden response
     *
     * @param AuthorizationException $exception
     * @param int $code
     * @return JsonResponse
     */
    public function responseForbidden(AuthorizationException $exception, int $code = Response::HTTP_FORBIDDEN): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
        ], $code);
    }


}
