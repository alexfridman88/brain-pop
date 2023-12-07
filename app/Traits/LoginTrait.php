<?php

namespace App\Traits;

use App\Http\Resources\LoginResource;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

trait LoginTrait
{

    private function loginBy(string $entity, array $credentials): JsonResponse
    {

        $guard = Str::plural($entity);

        if (Auth::guard($guard)->attempt($credentials)) {

            /* @var Student|Teacher $student */
            $entity = Auth::guard($guard)->user();
            $entity->createToken('authToken');

            return response()->json(new LoginResource($entity));
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
