<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base Controller
 *
 * This class implements basic CRUD operations for a given model and its associated resource.
 */
abstract class CrudControllerAbstract extends Controller
{

    /**
     * Get the resource mapping for the model.
     *
     * @return array{model: Model, resource: JsonResource} The resource mapping array.
     */
    abstract protected function controllerMapping(): array;


    /**
     * Retrieve all records from the database and return them as a JSON response.
     *
     * @return JsonResponse - The JSON response containing the records
     * @throws Exception - If an error occurs during database query
     */
    public function index(): JsonResponse
    {
        try {
            /** @var Model $model */
            $model = $this->getModel();

            /** @var JsonResource $resource */
            $resource = $this->getResource();

            return response()->json($resource::collection($model::query()->get()));
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retrieve and return the JSON representation of a specific Model instance.
     *
     * @param Model $model The model instance to be shown.
     * @return JsonResponse The JSON response containing the model's representation.
     */
    public function showInstance(Model $model): JsonResponse
    {
        try {
            return response()->json(new ($this->getResource())($model));
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store an instance of the model.
     *
     * @param array $data The data to create the instance from.
     * @return JsonResponse The JSON response containing the created instance.
     */
    public function storeInstance(array $data): JsonResponse
    {
        try {
            $model = $this->getModel();
            $item = new $model($data);
            $item->save();
            return response()->json($item, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update an instance of the model.
     *
     * @param array $data The data to update the instance with.
     * @param Model $model The model instance to update.
     * @return JsonResponse The JSON response indicating the success of the update.
     */
    public function updateInstance(array $data, Model $model): JsonResponse
    {
        try {
            $model->fill($data);
            $model->save();
            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Destroy an instance of the model.
     *
     * @param Model $model The model instance to destroy.
     * @return JsonResponse The JSON response containing the result.
     */
    public function destroy(Model $model): JsonResponse
    {
        try {
            $model->delete();
            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json($exception, Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Get the model to be used for storing an instance.
     *
     * @return string The fully qualified class name of the model.
     */
    private function getModel(): string
    {
        return $this->controllerMapping()['model'];
    }

    /**
     * Get the resource for the current model instance.
     *
     * @return string The resource for the current model instance.
     */
    private function getResource(): string
    {
        return $this->controllerMapping()['resource'];
    }

}