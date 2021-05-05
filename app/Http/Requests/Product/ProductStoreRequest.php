<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
          "name" => ['required', 'size:225'],
          "short_description" => 'size:225',
          "description" => 'size:225',
          "price" => 'integer',
          "dataset" => 'required'
        ];
    }
}
