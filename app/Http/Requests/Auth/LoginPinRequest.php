<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginPinRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'pin-1' => 'required',
            'pin-2' => 'required',
            'pin-3' => 'required',
            'pin-4' => 'required',
        ];
    }
}
