<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait ApiResponder
{
    /**
     * Success Response
     */
    protected function successResponse(
        $data = null,
        string $message = 'Success',
        int $code = Response::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        $response = [
            'success'   => true,
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
            'timestamp' => now()->toISOString(),
        ];

        return response()->json($response, $code, $headers);
    }

    /**
     * Error Response
     */
    protected function errorResponse(
        $data = null,
        string $message = 'Error',
        int $code = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ): JsonResponse {
        $response = [
            'success'   => false,
            'code'      => $code,
            'message'   => $message,
            'errors'    => $data, // Ubah dari 'data' ke 'errors' untuk consistency
            'timestamp' => now()->toISOString(),
        ];

        // Auto log untuk server errors (5xx)
        if ($code >= 500) {
            Log::error("API Error: {$message}", [
                'code'   => $code,
                'errors' => $data,
                'url'    => request()->fullUrl(),
                'ip'     => request()->ip(),
            ]);
        }

        return response()->json($response, $code, $headers);
    }

    /**
     * Not Found Response
     */
    protected function notFoundResponse(
        string $message = 'Resource not found',
        $errors = null
    ): JsonResponse {
        return $this->errorResponse($errors, $message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Validation Error Response
     */
    protected function validationErrorResponse(
        $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return $this->errorResponse($errors, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Unauthorized Response
     */
    protected function unauthorizedResponse(
        string $message = 'Unauthorized',
        $errors = null
    ): JsonResponse {
        return $this->errorResponse($errors, $message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Forbidden Response
     */
    protected function forbiddenResponse(
        string $message = 'Forbidden',
        $errors = null
    ): JsonResponse {
        return $this->errorResponse($errors, $message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Created Response (201)
     */
    protected function createdResponse(
        $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return $this->successResponse($data, $message, Response::HTTP_CREATED);
    }

    /**
     * No Content Response (204)
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Paginated Response
     */
    protected function paginatedResponse(
        $paginator,
        string $message = 'Success',
        array $meta = []
    ): JsonResponse {
        $response = [
            'success'    => true,
            'code'       => Response::HTTP_OK,
            'message'    => $message,
            'data'       => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
            'meta'       => $meta,
            'timestamp'  => now()->toISOString(),
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
