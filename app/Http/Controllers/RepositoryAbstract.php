<?php

namespace App\Http\Controllers;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RepositoryAbstract
 *
 * This abstract class is used as a base for concrete repository classes that implement the RepositoryInterface.
 * It extends the Controller class and provides methods for handling CRUD operations on model instances.
 */
abstract class RepositoryAbstract extends Controller implements RepositoryInterface
{
    public JsonResource $resource;

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
    private function getMappedModel(): string
    {
        return $this->controllerMapping()['model'];
    }

    /**
     * Get the resource associated with the controller.
     *
     * @return string The resource associated with the controller.
     */
    private function getMappedResource(): string
    {
        return $this->controllerMapping()['resource'];
    }

    /**
     * Get the index instance of the repository.
     *
     * This method returns the repository instance after performing indexing operations.
     *
     * @return RepositoryAbstract The index instance of the repository.
     */
    public function indexInstance(): RepositoryAbstract
    {
        /** @var Model $model */
        $model = $this->getMappedModel();

        /** @var JsonResource $resource */
        $resource = $this->getMappedResource();

        $this->resource = $resource::collection($model::query()->get());
        return $this;
    }

    /**
     * Show an instance of a resource.
     *
     * This method creates a new instance of a resource using the provided model,
     * and assigns it to the "resource" property of the current controller object.
     *
     * @param Model $model The model used to create the resource instance.
     * @return RepositoryAbstract The current controller object.
     */
    public function showInstance(Model $model): RepositoryAbstract
    {
        $this->resource = new ($this->getMappedResource())($model);
        return $this;
    }

    /**
     * Stores an instance of the model in the database.
     *
     * @param array $data The data to store.
     *
     * @return RepositoryAbstract The repository instance.
     */
    public function storeInstance(array $data): RepositoryAbstract
    {
        $item = new ($this->getMappedModel())($data);
        $item->save();
        return $this;
    }

    /**
     * Updates an instance of the model in the database.
     *
     * @param array $data The updated data for the model.
     * @param Model $model The model instance to be updated.
     *
     * @return RepositoryAbstract The repository instance.
     */
    public function updateInstance(Model $model, array $data): RepositoryAbstract
    {
        $model->update($data);
        return $this;
    }

    /**
     * Deletes an instance of the model from the database.
     *
     * @param Model $model The model instance to delete.
     *
     * @return RepositoryAbstract The repository instance.
     */
    public function destroyInstance(Model $model): RepositoryAbstract
    {
        $model->delete();
        return $this;
    }

}
