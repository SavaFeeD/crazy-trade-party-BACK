<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ApiBaseRequest;

class ProductStoreRequest extends ApiBaseRequest
{
    public function rules()
    {
        return [
          "user_id" => ['required', 'integer'],
          "name" => 'required',
          "price" => 'integer',
          "dataset" => 'required'
        ];
    }
}
