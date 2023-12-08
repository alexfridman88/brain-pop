<?php

namespace App\Http\Controllers;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

abstract class RepositoryAbstract extends Controller implements RepositoryInterface
{

    /**
     * Get the mapping between controllers and their corresponding methods.
     *
     * This method should be implemented by concrete classes that extend
     * the abstract controller class. It should return an array of mappings,
     * where the keys are the controller names and the values are the method names.
     *
     * @return array The mapping between controllers and methods.
     */
    abstract protected function controllerMapping(): array;

    /**
     * Get the model class name based on the controller mapping.
     *
     * @return string The model class name.
     */
    private function getModel(): string
    {
        return $this->controllerMapping()['model'];
    }

    /**
     * Get the resource associated with the controller.
     *
     * @return string The resource associated with the controller.
     */
    private function getResource(): string
    {
        return $this->controllerMapping()['resource'];
    }

    /**
     * Retrieves and returns all instances of a model in JSON format.
     *
     * @return JsonResponse A JSON response containing the collection of model instances.
     */
    public function indexInstance(): JsonResponse
    {
        /** @var Model $model */
        $model = $this->getModel();

        /** @var JsonResource $resource */
        $resource = $this->getResource();
        return $this->responseJson($resource::collection($model::query()->get()));
    }

    /**
     * Retrieves and returns a specific instance of a model in JSON format.
     *
     * @param Model $model The model instance to be shown.
     * @return JsonResponse A JSON response containing the model instance.
     */
    public function showInstance(Model $model): JsonResponse
    {
        return $this->responseJson(new ($this->getResource())($model));
    }


    /**
     * Store an instance of a model with the given data.
     *
     * @param array $data The data to be stored for the model instance.
     * @return JsonResponse The JSON response with the success message and HTTP status code.
     */
    public function storeInstance(array $data): JsonResponse
    {
        $model = $this->getModel();
        $item = new $model($data);
        $item->save();
        return $this->responseOk('success', Response::HTTP_CREATED);
    }

    /**
     * Update an instance of the model in the database.
     *
     * @param array $data The data to be updated in the instance.
     * @param Model $model The instance of the model to be updated.
     * @return JsonResponse The JSON response indicating the success of the update.
     */
    public function updateInstance(array $data, Model $model): JsonResponse
    {
        $model->update($data);
        return $this->responseOk();
    }

    /**
     * Delete an instance of the model from the database.
     *
     * @param Model $model The model instance to be deleted.
     * @return JsonResponse The JSON response indicating the success of the deletion.
     */
    public function destroyInstance(Model $model): JsonResponse
    {
        $model->delete();
        return $this->responseOk();
    }

}
