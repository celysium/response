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
    public static function json(mixed $data, string $type, string $message, int $statusCode = ResponseClass::HTTP_OK, array $additional = []): JsonResponse
    {
        return BaseResponse::json(
            array_merge([
                'type'    => $type,
                'message' => $message,
                'data'    => $data,
            ], $additional),
            $statusCode
        );
    }

    public static function success($data = [], string $type = 'success', string $message = null, int $statusCode = ResponseClass::HTTP_OK, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.success'),
            $statusCode,
            $additional
        );
    }

    public static function info($data, string $type = 'info', string $message = null, int $statusCode = ResponseClass::HTTP_OK, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.info'),
            $statusCode,
            $additional
        );
    }

    public static function created($data, string $type = 'success', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.created'),
            ResponseClass::HTTP_CREATED,
            $additional
        );
    }

    public static function deleted($data = [], string $type = 'success', string $message = null, array $additional = []): JsonResponse
    {
        return static::success(
            $data,
            $type,
            $message ?? __('response::response.deleted'),
            ResponseClass::HTTP_OK,
            $additional
        );
    }

    public static function badRequest($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.badRequest'),
            ResponseClass::HTTP_BAD_REQUEST,
            $additional
        );
    }

    public static function serverError($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.serverError'),
            ResponseClass::HTTP_INTERNAL_SERVER_ERROR,
            $additional
        );
    }

    public static function notFound($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.notFound'),
            ResponseClass::HTTP_NOT_FOUND,
            $additional
        );
    }

    public static function unauthorized($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.unauthorized'),
            ResponseClass::HTTP_UNAUTHORIZED,
            $additional
        );
    }

    public static function forbidden($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.forbidden'),
            ResponseClass::HTTP_FORBIDDEN,
            $additional
        );
    }

    public static function unprocessable($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.unprocessable'),
            ResponseClass::HTTP_UNPROCESSABLE_ENTITY,
            $additional
        );
    }

    public static function tooManyRequests($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.tooManyRequests'),
            ResponseClass::HTTP_TOO_MANY_REQUESTS,
            $additional
        );
    }

    public static function methodNotAllowed($data = [], string $type = 'error', string $message = null, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message ?? __('response::response.methodNotAllowed'),
            ResponseClass::HTTP_METHOD_NOT_ALLOWED,
            $additional
        );
    }

    public static function error($data = [], string $type = 'error', string $message = null, int $statusCode = ResponseClass::HTTP_INTERNAL_SERVER_ERROR, array $additional = []): JsonResponse
    {
        return static::json(
            $data,
            $type,
            $message,
            $statusCode,
            $additional
        );
    }

    public static function collection(LengthAwarePaginator|Collection|ResourceCollection|array $data, string $type = 'info', string $message = null, int $statusCode = ResponseClass::HTTP_OK, array $additional = []): JsonResponse
    {
        $meta = [];
        if ($data instanceof Collection) {
            $data = $data->toArray();
        } elseif ($data instanceof ResourceCollection) {
            $meta = static::getMeta($data->resource->toArray());
            $data = $data->collection;
        } elseif ($data instanceof LengthAwarePaginator) {
            $meta = static::getMeta($data->toArray());
            $data = $data->items();
        }

        return static::json(
            $data,
            $type,
            $message ?? __('response::response.info'),
            $statusCode,
            array_merge($additional, ['meta' => $meta])
        );
    }

    public static function getMeta(array $meta): array
    {
        return Arr::only($meta, config('response.meta'));
    }
}
