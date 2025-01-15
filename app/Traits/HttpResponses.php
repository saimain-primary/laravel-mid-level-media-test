<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function forbidden()
    {
        return response()->json([
            'success' => false,
            'message' => 'You do not have permission',
            'data' => []
        ], 403);
    }
}
