<?php

namespace App\Http\Requests\BranchOffice;

use App\BranchOffice;
use App\Http\Requests\Request;

class UpdateBranchOffice extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:branch_offices,name,' .$this->id,
            'email_song' => 'required|email',
            'email_reservations' => 'required|email',
            'lat' => 'required',
            'lng' => 'required'
        ];
    }
}
