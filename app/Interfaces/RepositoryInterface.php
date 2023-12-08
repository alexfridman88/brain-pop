<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface RepositoryInterface
{

    public function indexInstance(): JsonResponse;

    public function showInstance(Model $model): JsonResponse;

    public function storeInstance(array $data): JsonResponse;

    public function updateInstance(array $data, Model $model): JsonResponse;

    public function destroyInstance(Model $model): JsonResponse;
}
