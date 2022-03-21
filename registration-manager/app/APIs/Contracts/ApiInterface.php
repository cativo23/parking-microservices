<?php

namespace App\APIs\Contracts;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

interface ApiInterface
{
    /**
     * Must be able to make a request to an API Endpoint
     */
    public function makeRequest(string $uri, array $query, string $method = 'get'): PromiseInterface|Response|null;
}
