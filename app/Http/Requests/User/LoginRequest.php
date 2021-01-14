<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiBaseRequest;

class LoginRequest extends ApiBaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => 'required'
        ];
    }
}
