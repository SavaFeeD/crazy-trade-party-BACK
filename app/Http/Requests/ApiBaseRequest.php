<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiBaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator, $code = 422)
    {
        $errors = collect($validator->errors())->map(function($item){ return $item[0]; });
        throw new HttpResponseException(response()->json([
            "status" => false,
            "body" => $errors
        ], $code));
    }
}
