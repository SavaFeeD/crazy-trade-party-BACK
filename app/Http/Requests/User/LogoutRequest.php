<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiBaseRequest;

class LogoutRequest extends ApiBaseRequest
{
    public function rules()
    {
        return [
            'id' => 'required'
        ];
    }
}
