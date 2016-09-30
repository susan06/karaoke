<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\User;

class UpdateProfileLoginDetailsRequest extends UpdateLoginDetailsRequest
{
    /**
     * Get authenticated user.
     *
     * @return mixed
     */
    protected function getUserForUpdate()
    {
        return \Auth::user();
    }
}
