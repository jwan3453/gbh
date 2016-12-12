<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JoinUnionRequest extends Request
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
            'Union.hotel_name'    => 'required|unique:hotel_union',
            'Union.hotel_address' => 'required',
            'Union.hotel_number'  => 'required|unique:hotel_union',
            'Union.person_number' => 'required|unique:hotel_union',
            'Union.hotel_person'  => 'required',
            'Union.person_email'  => 'required',
            'Union.remarks'       => 'required',
        ];
    }
}
