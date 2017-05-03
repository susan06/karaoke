<?php

namespace App\Http\Requests\song;

use App\Http\Requests\Request;

class ImportSongRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'csv_import' => 'required'
        ];
        
    }
}
