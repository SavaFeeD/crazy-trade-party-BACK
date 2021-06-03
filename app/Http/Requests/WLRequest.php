<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WLRequest extends ApiBaseRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|unique:users,id|integer',
            'product_id' => 'required|unique:products,id|integer'
        ];
    }
}
