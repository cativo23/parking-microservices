<?php

namespace App\APIs;

use App\APIs\Contracts\ApiInterface;
use App\Exceptions\APIs\Publimovil\Broadsign\InitializationFailed;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;
use App\Jobs\APIs\BaseGetAvailabilityJob;
use Cache;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use phpDocumentor\Reflection\Types\ClassString;

abstract class BaseAPI implements ApiInterface
{
    /**
     * The base url of the de API
     */
    protected string $baseUrl = '';

    /**
     * The token for authorization
     */
    protected string $token = '';

    /**
     * ID of the units to search the availability
     */
    protected ?array $unitIds = null;

    /**
     * The HTTP Request
     */
    protected PendingRequest $http;

    public function __construct()
    {
        $this->setConfigs();
        $this->http = $this->initialize();
    }

    /**
     * @throws RequestError
     * @throws StatusNotExpected
     */
    public function makeRequest(string $uri, array $query = []): PromiseInterface|Response|null
    {
        try {
            $response = $this->http->get($uri, $query);
        } catch (Exception $exception) {
            throw new RequestError('Something went wrong in request', previous: $exception);
        }

        if ($response->serverError()) {
            throw new StatusNotExpected('Error No Expected');
        }

        if ($response->status() === 404) {
            return null;
        }

        return $response;
    }

    /**
     * Initialization of the HTTP Request with based config
     */
    public function initialize(): PendingRequest
    {
        return Http::acceptJson()->withToken($this->token)->baseUrl($this->baseUrl);
    }

    abstract public function setConfigs(): void;
}
