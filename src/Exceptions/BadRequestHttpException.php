<?php

namespace Celysium\Responser\Exceptions;

use Celysium\Responser\Responser;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseClass;
use Throwable;

class BadRequestHttpException extends Exception
{
    public function __construct(public Response $response, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        $response = $this->response->json();
        return Responser::error($response['data'], $response['messages'], ResponseClass::HTTP_BAD_REQUEST, $response['meta']);
    }

}
