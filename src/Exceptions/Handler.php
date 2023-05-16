<?php

namespace Celysium\Responser\Exceptions;

use Carbon\Exceptions\BadMethodCallException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Celysium\Responser\Responser;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->renderable(function (AuthorizationException $exception) {
            return Responser::forbidden();
        });

        $this->renderable(function (AccessDeniedHttpException $exception) {
            return Responser::forbidden();
        });

        $this->renderable(function (AuthenticationException $exception) {
            return Responser::unauthorized();
        });

        $this->renderable(function (ModelNotFoundException $exception) {
            return Responser::notFound();
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            return Responser::notFound();
        });

        $this->renderable(function (MethodNotAllowedHttpException $exception) {
            return Responser::notFound();
        });

        $this->renderable(function (BadMethodCallException $exception) {
            return Responser::error();
        });

        $this->renderable(function (ValidationException $exception) {
            return Responser::unprocessable(
                $exception->errors()
            );
        });

        $this->renderable(function (ConnectionException $exception) {
            return Responser::error();
        });

        $this->renderable(function (TooManyRequestsHttpException $exception) {
            return Responser::tooManyRequests();
        });

        $this->renderable(function (Exception $exception) {
            return Responser::serverError();
        });
    }
    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context(): array
    {
        $request = app('request');
        $data = [
            'uri' => $request->route()->uri,
            'method' => $request->method(),
            'query' => $request->query(),
            'headers' => $request->header(),
            'parameters' => Arr::except($request->all(), array_keys($request->query())),
            'fired_at' => now()->toString()
        ];
        return array_merge(['request' => json_encode($data, JSON_PRETTY_PRINT)], parent::context());
    }
}
