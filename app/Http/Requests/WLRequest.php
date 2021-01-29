<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WLRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer'
        ];
    }
}
