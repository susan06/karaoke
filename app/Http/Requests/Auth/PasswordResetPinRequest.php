<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class PasswordResetPinRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'pin-1' => 'required|min:1|max:9|integer',
            'pin-2' => 'required|min:1|max:9|integer',
            'pin-3' => 'required|min:1|max:9|integer',
            'pin-4' => 'required|min:1|max:9|integer',
        ];
    }
}
