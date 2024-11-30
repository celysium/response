<?php

namespace Celysium\Response\Exceptions;

use Carbon\Exceptions\BadMethodCallException;
use Celysium\Response\Response;
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
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * @param $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e) : \Symfony\Component\HttpFoundation\Response
    {
        if (env('APP_DEBUG')) {
            return parent::render($request, $e);
        }
        if (!$request->isJson()) {
            return parent::render($request, $e);
        }
        return match (get_class($e)) {
            AuthorizationException::class,
            AccessDeniedHttpException::class => Response::forbidden(),
            ValidationException::class => Response::unprocessable($e->errors()),
            AuthenticationException::class => Response::unauthorized(),
            ModelNotFoundException::class,
            NotFoundHttpException::class => Response::notFound(),
            MethodNotAllowedHttpException::class => Response::methodNotAllowed(),
            BadMethodCallException::class,
            ConnectionException::class => Response::badRequest(),
            TooManyRequestsHttpException::class => Response::tooManyRequests(),
            default => Response::serverError()
        };
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
            $meta['request'] = json_encode([
                'path'       => $request->path(),
                'method'     => $request->method(),
                'parameters' => $request->all(),
                'headers'    => Arr::except($request->headers->all(), 'Authorization'),
            ]);
            return array_merge($meta, parent::context());
        }
        return parent::context();
    }
}
