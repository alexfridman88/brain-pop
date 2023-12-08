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

    /**
     * Authenticates a user by their entity type using the specified credentials.
     *
     * @param string $entity The entity type of the user (e.g. student, teacher).
     * @param array $credentials The login credentials of the user.
     * @return JsonResponse The JSON response containing the user's login details if successful, otherwise an error message.
     */
    private function loginBy(string $entity, array $credentials): JsonResponse
    {

        $guard = Str::plural($entity);

        if (Auth::guard($guard)->attempt($credentials)) {

            /* @var Student|Teacher $entity */
            $entity = Auth::guard($guard)->user();
            $entity->createToken('authToken');

            return response()->json(new LoginResource($entity));
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
