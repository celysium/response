<?php

namespace Celysium\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response as BaseResponse;
use Symfony\Component\HttpFoundation\Response as ResponseClass;

class Response
{
    public static function json($data = [], $messages = [], int $statusCode = ResponseClass::HTTP_OK, $meta = []): JsonResponse
    {
        return BaseResponse::json(
            [
                'messages' => $messages,
                'data' => $data,
                'meta' => $meta,
            ],
            $statusCode
        );
    }

    public static function success($data = [], $messages = [], int $statusCode = ResponseClass::HTTP_OK, $meta = []): JsonResponse
    {
        if (count($messages) == 0) {
            $messages[] = [
                'type' => 'success',
                'text' => __('response::response.success')
            ];
        }

        return static::json(
            $data,
            $messages,
            $statusCode,
            $meta
        );
    }

    public static function info($data, $messages = [], int $statusCode = ResponseClass::HTTP_OK, $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'info',
                'text' => __('response::response.info')
            ];
        }

        return static::json(
            $data,
            $messages,
            $statusCode,
            $meta
        );
    }

    public static function created($data, $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'success',
                'text' => __('response::response.created')
            ];
        }

        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_CREATED,
            $meta
        );
    }

    public static function deleted($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'success',
                'text' => __('response::response.deleted')
            ];
        }

        return static::success(
            $data,
            $messages,
            ResponseClass::HTTP_OK,
            $meta
        );
    }

    public static function error($data = [], $messages = [], int $statusCode = ResponseClass::HTTP_BAD_REQUEST, $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.error')
            ];
        }

        return static::json(
            $data,
            $messages,
            $statusCode,
            $meta
        );
    }

    public static function serverError($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.serverError')
            ];
        }

        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_INTERNAL_SERVER_ERROR,
            $meta
        );
    }

    public static function notFound($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.notFound')
            ];
        }

        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_NOT_FOUND,
            $meta
        );
    }

    public static function unauthorized($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.unauthorized')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_UNAUTHORIZED,
            $meta
        );
    }

    public static function forbidden($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.forbidden')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_FORBIDDEN,
            $meta
        );
    }

    public static function unprocessable($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.unprocessable')
            ];
        }

        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_UNPROCESSABLE_ENTITY,
            $meta
        );
    }

    public static function paymentRequired($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.paymentRequired')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_PAYMENT_REQUIRED,
            $meta
        );
    }

    public static function tooManyRequests($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.tooManyRequests')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_TOO_MANY_REQUESTS,
            $meta
        );
    }

    public static function methodNotAllowed($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.methodNotAllowed')
            ];
        }

        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_METHOD_NOT_ALLOWED,
            $meta
        );
    }

    public static function methodNotAcceptable($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.notAcceptable')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_NOT_ACCEPTABLE,
            $meta
        );
    }

    public static function proxyAuthenticationRequired($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.proxyAuthenticationRequired')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_PROXY_AUTHENTICATION_REQUIRED,
            $meta
        );
    }

    public static function requestTimeout($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.requestTimeout')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_REQUEST_TIMEOUT,
            $meta
        );
    }

    public static function conflict($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.conflict')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_CONFLICT,
            $meta
        );
    }

    public static function gone($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.gone')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_GONE,
            $meta
        );
    }

    public static function lengthRequired($data = [], $messages = [], $meta = []): JsonResponse
    {
        if (empty($messages)) {
            $messages[] = [
                'type' => 'error',
                'text' => __('response::response.lengthRequired')
            ];
        }
        return static::json(
            $data,
            $messages,
            ResponseClass::HTTP_LENGTH_REQUIRED,
            $meta
        );
    }

    public static function collection(LengthAwarePaginator|Collection|ResourceCollection|array $data, $messages = [], int $statusCode = ResponseClass::HTTP_OK): JsonResponse
    {
        $meta = [];
        if($data instanceof Collection) {
            $data = $data->toArray();
        }
        elseif ($data instanceof ResourceCollection) {
            $meta = static::getMeta($data->resource->toArray());
            $data = $data->collection;
        }
        elseif ($data instanceof LengthAwarePaginator) {
            $meta = static::getMeta($data->toArray());
            $data = $data->items();
        }

        if (empty($messages)) {
            $messages[] = [
                'type' => 'info',
                'text' => __('response::response.info')
            ];
        }

        return static::json($data, $messages, $statusCode, $meta);
    }

    public static function getMeta(array $meta): array
    {
        return Arr::only($meta, config('response.meta'));
    }
}
