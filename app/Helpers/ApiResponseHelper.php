<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    /**
     * @param string|null $message
     * @param int $code
     * @param array $errors
     *
     * @return JsonResponse
     */
    public static function fail($message = null, $code = 500, $errors = [])
    {
        return response()->json([
            'status' => 'failure',
            'status_code' => $code,
            'message' => $message ? $message : 'Internal Server Error',
            'errors' => $errors,
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param $data
     * @param array $meta
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function success($data = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'status_code' => $code,
            'message' => JsonResponse::$statusTexts[$code] = 'OK',
            'data' => $data ? $data : '',
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_OK);
    }

    /**
     * @param string|null $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function badRequest($message, $code = 400)
    {
        return response()->json([
            'status' => 'Bad Request',
            'status_code' => $code,
            'message' => $message ? $message : 'Bad Request',
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @param string|null $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function notFound($message, $code = 404)
    {
        return response()->json([
            'status' => 'Not Found',
            'status_code' => $code,
            'message' => $message ? $message : 'Not Found',
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @param string|null $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function forbidden($message, $code = 403)
    {
        return response()->json([
            'status' => 'Forbidden',
            'status_code' => $code,
            'message' => $message ? $message : 'Forbidden',
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * @param string|null $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function unauthorized($message, $code = 401)
    {
        return response()->json([
            'status' => 'Unauthorized',
            'status_code' => $code,
            'message' => $message ? $message : 'Unauthorized',
        ], isset(JsonResponse::$statusTexts[$code]) ? $code : JsonResponse::HTTP_UNAUTHORIZED);
    }
}
