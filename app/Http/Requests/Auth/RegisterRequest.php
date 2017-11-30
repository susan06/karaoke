<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            //'password' => 'required|confirmed|min:4',
            'first_name' => 'required',
            'last_name' => 'required',
            //'pin-1' => 'required|min:1|max:9|integer',
            //'pin-2' => 'required|min:1|max:9|integer',
            //'pin-3' => 'required|min:1|max:9|integer',
            //'pin-4' => 'required|min:1|max:9|integer',
        ];

    }

}
