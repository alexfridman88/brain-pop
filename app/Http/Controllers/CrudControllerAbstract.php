<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

abstract class CrudControllerAbstract extends Controller
{

    abstract protected function controllerMapping(): array;


    public function indexInstance(): JsonResponse
    {
        /** @var Model $model */
        $model = $this->getModel();

        /** @var JsonResource $resource */
        $resource = $this->getResource();
        return response()->json($resource::collection($model::query()->get()));

    }

    /**
     * Retrieve and return the JSON representation of a specific Model instance.
     *
     * @param Model $model The model instance to be shown.
     * @return JsonResponse The JSON response containing the model's representation.
     */
    public function showInstance(Model $model): JsonResponse
    {
        return response()->json(new ($this->getResource())($model));
    }

    public function storeInstance(array $data): JsonResponse
    {
        $model = $this->getModel();
        $item = new $model($data);
        $item->save();
        return response()->json($item, Response::HTTP_CREATED);
    }

    public function updateInstance(array $data, Model $model): JsonResponse
    {
        $model->fill($data);
        $model->save();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    public function destroyInstance(Model $model): JsonResponse
    {
        $model->delete();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    private function getModel(): string
    {
        return $this->controllerMapping()['model'];
    }

    private function getResource(): string
    {
        return $this->controllerMapping()['resource'];
    }

}
