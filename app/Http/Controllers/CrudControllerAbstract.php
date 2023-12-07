<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CrudControllerAbstract
 *
 * This abstract class provides basic CRUD functionalities for a controller that manages a specific model.
 */
abstract class CrudControllerAbstract extends Controller
{


    /**
     * Get the mapping of controller methods.
     *
     * @return array{model:Model, resource:JsonResponse} The mapping of controller methods.
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
        return response()->json(new ($this->getResource())($model));
    }

    /**
     * Store an instance of the model.
     *
     * @param array $data The data to create the instance from.
     * @return JsonResponse The JSON response containing the created instance.
     */
    public function storeInstance(array $data): JsonResponse
    {
        $model = $this->getModel();
        $item = new $model($data);
        $item->save();
        return response()->json($item, Response::HTTP_CREATED);
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
        $model->fill($data);
        $model->save();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }


    /**
     * Destroy an instance of the model.
     *
     * @param Model $model The instance to destroy.
     * @return JsonResponse The JSON response indicating the result of the deletion.
     *                      A success message will be returned if the deletion was successful.
     *                      An error message will be returned if the deletion was unsuccessful.
     */
    public function destroyInstance(Model $model): JsonResponse
    {
        $model->delete();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
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
