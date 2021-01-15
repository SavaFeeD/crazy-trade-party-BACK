<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class AttrNameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
