<?php

namespace App\Http\Requests\BranchOffice;

use App\Http\Requests\Request;

class CreateBranchOffice extends Request
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
            'name' => 'required|unique:branch_offices,name',
            'email_song' => 'required|email',
            'email_reservations' => 'required|email',
            'lat' => 'required',
            'lng' => 'required',
            'reservation_time_max' => 'required'
        ];
    }
}
