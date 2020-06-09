<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidationErrorException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     */
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code' => 422,
                'title' => 'User not found',
                'detail' => 'Your request is missing fields',
                'meta' => json_decode($this->getMessage()),
            ]
        ], 422);
    }
}
