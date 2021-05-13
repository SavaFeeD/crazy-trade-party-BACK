<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws \HttpResponseException
     */
    protected function redirectTo($request)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'body' => [
                'message' => 'Вам необходима авторизация'
            ]
        ], 401));
    }
}
