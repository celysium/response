<?php

namespace Celysium\Response\Exceptions;

use Carbon\Exceptions\BadMethodCallException;
use Celysium\Response\Response;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    public function register()
    {
        if (!env('RESPONSE_EXCEPTION_HANDLER')) {
            return;
        }
        $this->renderable(function (AuthorizationException $exception) {
            return Response::forbidden();
        });

        $this->renderable(function (AccessDeniedHttpException $exception) {
            return Response::forbidden();
        });

        $this->renderable(function (AuthenticationException $exception) {
            return Response::unauthorized();
        });

        $this->renderable(function (ModelNotFoundException $exception) {
            return Response::notFound();
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            return Response::notFound();
        });

        $this->renderable(function (MethodNotAllowedHttpException $exception) {
            return Response::notFound();
        });

        $this->renderable(function (BadMethodCallException $exception) {
            return Response::error();
        });

        $this->renderable(function (ValidationException $exception) {
            return Response::unprocessable(
                $exception->errors()
            );
        });

        $this->renderable(function (ConnectionException $exception) {
            return Response::error();
        });

        $this->renderable(function (TooManyRequestsHttpException $exception) {
            return Response::tooManyRequests();
        });

        $this->renderable(function (Exception $exception) {
            return Response::serverError();
        });
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context(): array
    {
        /** @var Request $request */
        if ($request = request()) {
            $data = [
                'path'       => $request->path(),
                'method'     => $request->method(),
                'parameters' => $request->all(),
                'fired_at'   => now()->toString(),
                'headers'    => Arr::except($request->header(), 'Authorization'),
            ];
            return array_merge(['request' => json_encode($data, JSON_PRETTY_PRINT)], parent::context());
        }
        return parent::context();
    }
}
