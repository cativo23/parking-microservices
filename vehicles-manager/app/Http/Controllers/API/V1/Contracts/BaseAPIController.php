<?php

namespace App\Http\Controllers\API\V1\Contracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseAPIController extends Controller
{
    /**
     * HTTP header status code.
     *
     * @var int
     */
    protected int $statusCode = Response::HTTP_OK;

    /**
     * Generate a created Response.
     */
    protected function success(
        string $message = 'Success',
        array $data = [],
        string $description = null
    ): JsonResponse {
        return $this->respondWithSuccess($message, $data, $description);
    }

    /**
     * Generate a created Response.
     */
    protected function successCreated(
        string $message = 'Created',
        array $data = [],
        string $description = null
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_CREATED)->respondWithSuccess($message, $data, $description);
    }

    /**
     * Generate a created Response.
     */
    protected function successCreatedWithResource(
        JsonResource $data,
        string $message = 'Created',
        string $description = null
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondWithSuccess($message, $data->resolve(), $description);
    }

    /**
     * Generate an accepted response.
     */
    protected function successAccepted(
        string $message = 'Accepted',
        array $data = [],
        string $description = null
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_ACCEPTED)->respondWithSuccess($message, $data, $description);
    }

    /**
     * Generate a Response with a 403 HTTP header and a given message.
     */
    protected function errorForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Generate a Response with a 500 HTTP header and a given message.
     */
    protected function errorInternalError(string $message = 'Internal Error', array $data = []): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message, $data);
    }

    /**
     * Generate a Response with a 404 HTTP header and a given message.
     */
    protected function errorNotFound(string $message = 'Resource Not Found', string $description = null): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message, [], $description);
    }

    /**
     * Generate a Response with a 401 HTTP header and a given message.
     */
    protected function errorUnauthorized(string $message = 'Unauthorized', string $description = null): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message, [], $description);
    }

    /**
     * Generate a Response with a 400 HTTP header and a given message.
     */
    protected function errorWrongData(string $message = 'Bad Data Sent', string $description = null): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message, [], $description);
    }

    /**
     * Response with success.
     *
     * @param string $message
     * @param array $data
     * @param string|null $description
     * @return JsonResponse
     */
    protected function respondWithSuccess(string $message, array $data = [], string $description = null): JsonResponse
    {
        return $this->respondWithArray([
            'type' => 'success',
            'message' => $message,
            'description' => $description,
            'data' => $data,
            'status' => $this->statusCode,
        ]);
    }

    /**
     * Response with the current error.
     *
     * @param string $message
     * @param array $data
     * @param string $description
     * @return JsonResponse
     */
    protected function respondWithError(
        string $message,
        array $data = [],
        string $description = 'Something went wrong :('
    ): JsonResponse {
        return $this->respondWithArray([
            'type' => 'error',
            'message' => $message,
            'description' => $description,
            'data' => $data,
            'status' => $this->statusCode,
        ]);
    }

    /**
     * Respond with a given array of items.
     */
    protected function respondWithArray(array $array, array $headers = []): JsonResponse
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    /**
     * Setter for statusCode.
     */
    protected function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
