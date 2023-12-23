<?php

namespace App\Interfaces;

use App\Abstracts\RepositoryAbstract;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    public function indexInstance(): RepositoryAbstract;

    public function showInstance(Model $model): RepositoryAbstract;

    public function storeInstance(array $data): RepositoryAbstract;

    public function updateInstance(Model $model, array $data): RepositoryAbstract;

    public function destroyInstance(Model $model): RepositoryAbstract;
}
