<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseHelp {
    public static function success($message = 'success', $data = [], $statusCode = ResponseAlias::HTTP_OK) {
        return response(['status' => true, 'data' => $data , 'message' => $message], $statusCode);
    }

    public static function error($message = 'error', $data = [], $statusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR) {
        return response(['status' => false, 'data' => $data, 'message' => $message], $statusCode);
    }
}
