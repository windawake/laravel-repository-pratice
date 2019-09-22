<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
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
            'email'	=>'	required|min:8',
            'password'	=>'required|min:6',
            'confirm_password' =>'required|same:password',
            'role_id'	=>'required|integer',
            'admin_status'	=>'required|integer',
        ];
    }
}
