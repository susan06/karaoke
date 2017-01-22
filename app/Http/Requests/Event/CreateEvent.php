<?php

namespace App\Http\Requests\Event;

use App\Http\Requests\Request;

class CreateEvent extends Request
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
            'name' => 'required|unique:events,name',
            'description' => 'required',
            'branch_office_id' => 'required|exists:branch_offices,id'
        ];
    }
}
