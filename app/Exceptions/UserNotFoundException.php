<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserNotFoundException extends Exception
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
                'code' => 404,
                'title' => 'User not found',
                'detail' => 'Unable to locate the user with id: ' . $request->get('friend_id')
            ]
        ], 404);
    }
}
