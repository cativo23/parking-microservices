<?php

namespace App\Repositories\V1;

use App\Repositories\V1\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var class-string<Model>
     */
    protected string $model;

    protected array $allowedFilters = [];

    protected array $allowedFiltersExact = [];

    protected array $allowedFiltersScope = [];

    protected array $allowedIncludes = [];

    protected array $allowedSorts = [];

    protected array $defaultSorts = [];

    public function __construct()
    {
        $this->model = $this->model();
    }

    /**
     *
     * The Eloquent model.
     *
     * @return class-string<Model>
     */
    abstract protected function model(): string;

    public function index(): QueryBuilder
    {
        return QueryBuilder::for($this->model)->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->allowedIncludes)
            ->defaultSorts($this->defaultSorts)
            ->allowedSorts($this->allowedSorts);
    }

    public function getById(int $id): ?Model
    {
        return $this->model::find($id);
    }

    public function delete(int $id): bool
    {
        $object = $this->getById($id);
        if ($object) {
            return $object->delete();
        }

        return false;
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(Model $object, array $data): bool
    {
        return $object->update($data);
    }

    private function getExactAllowedFilters(): array
    {
        $allowedFiltersExact = [];
        foreach ($this->allowedFiltersExact as $filter) {
            $allowedFiltersExact[] = AllowedFilter::exact($filter);
        }
        return $allowedFiltersExact;
    }

    private function getScopeFilters(): array
    {
        $allowedFiltersScope = [];
        foreach ($this->allowedFiltersScope as $filter) {
            $allowedFiltersScope[] = AllowedFilter::scope($filter);
        }
        return $allowedFiltersScope;
    }

    private function getAllowedFilters(): array
    {
        return array_merge($this->allowedFilters, $this->getExactAllowedFilters(), $this->getScopeFilters());
    }
}
