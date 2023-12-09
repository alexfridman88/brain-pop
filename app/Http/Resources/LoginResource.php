<?php

namespace App\Http\Resources;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Teacher|Student */
class LoginResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'full_name' => $this->full_name,
            'token' => $this->createToken('authToken')->plainTextToken,
        ];
    }
}
