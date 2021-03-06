<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UpdateProfileDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = \Auth::user();

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'date',
            'email' => 'required|email|unique:users,email,' . $user->id
        ];
    }
}
