<?php

namespace App\Http\Controllers\API\V1\Contracts;

use App\Http\Requests\V1\IndexRequest;
use App\Repositories\V1\Contracts\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class CrudBaseController extends BaseAPIController
{

    /**
     * @var class-string<JsonResource>
     */
    protected string $resource;

    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->resource = $this->resource();
    }

    /**
     *
     * The model resource.
     *
     * @return class-string<JsonResource>
     */
    abstract protected function resource(): string;

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $result = $this->repository->index()->simplePaginate($request->input('paginate', 10))->withQueryString();

        return $this->resource::collection($result);
    }

    /**
     * Display the specified resource.
     */
    abstract public function show(string|int $id);

    /**
     * Remove the specified resource from storage.
     */
    abstract public function destroy(int $id): JsonResponse;
}
