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

    private string $guardName;

    /**
     * Logs in the user using the specified entity and credentials.
     *
     * @param string $entity The entity to log in as.
     * @param array $credentials The credentials for the login attempt.
     *
     * @return static The current instance of the class.
     */
    private function loginBy(string $entity, array $credentials): static
    {
        $this->guardName = Str::plural($entity);
        Auth::guard($this->guardName)->attempt($credentials);
        return $this;
    }

    /**
     * Generate the login response.
     *
     * @return JsonResponse
     */
    private function responseLogin(): JsonResponse
    {
        /** @var Student|Teacher $entity */
        $entity = Auth::guard($this->guardName)->user();

        if ($entity) {
            return response()->json(new LoginResource($entity), Response::HTTP_OK);
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
