<?php

namespace App\Traits;

/**
 * Trait StudentBaseRequest
 *
 * This trait contains the base validation rules for a Student request.
 * It provides a method to retrieve the base validation rules as an array.
 */
trait StudentBaseRequest
{
    /**
     * This method defines the base request structure for a specific operation.
     *
     * @return array Returns an array that defines the required fields and their validation rules.
     * The 'full_name' field is required and must be a string.
     * The 'grade' field is required, must be an integer, and must be between the values 0 and 12 (inclusive).
     */
    private function baseRequest(): array
    {
        return [
            'full_name' => ['required', 'string'],
            'grade' => ['int', 'required', 'between:0,12']
        ];
    }
}
