<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function rules() {
        return [
            'username' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ];
    }
}
