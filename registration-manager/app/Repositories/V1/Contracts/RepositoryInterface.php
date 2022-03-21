<?php

namespace App\Repositories\V1\Contracts;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

interface RepositoryInterface
{
    public function index(): QueryBuilder;

    public function getById(int $id): ?Model;

    public function delete(Model $object): bool;

    public function create(array $data): Model;

    public function update(Model $object, array $data): bool;
}
