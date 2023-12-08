<?php

namespace App\Traits;

/**
 * Trait TeacherBaseRequestTrait
 *
 * This trait contains the base validation rules for a Teacher request.
 * It provides a method to retrieve the base validation rules as an array.
 */
trait TeacherBaseRequestTrait
{
    /**
     * Returns an array defining the base request parameters.
     *
     * @return array The array containing the base request parameters.
     * The 'full_name' parameter is required and must be a string.
     * The 'email' parameter is required and must be a valid email address.
     */
    private function baseRequest(): array
    {
        return [
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email']
        ];
    }
}
