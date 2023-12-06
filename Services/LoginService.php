<?php

namespace App\Services;

use App\Http\Resources\LoginResource;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginService
{
    public function student($credentials): JsonResponse
    {
        return $this->login('students', $credentials);
    }

    public function teacher($credentials): JsonResponse
    {
        return $this->login('teachers', $credentials);

    }

    private function login(string $guard, array $credentials): JsonResponse
    {
        if (Auth::guard($guard)->attempt($credentials)) {

            /* @var Student|Teacher $student */
            $entity = Auth::guard($guard)->user();
            $entity->createToken('authToken');

            return response()->json(new LoginResource($student));
        }

        return response()->json('Login failed', Response::HTTP_FORBIDDEN);
    }
}
