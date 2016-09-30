<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class CreateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'username' => 'unique:users,username',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'date',
            'role' => 'required|exists:roles,id'
        ];
    }
}
