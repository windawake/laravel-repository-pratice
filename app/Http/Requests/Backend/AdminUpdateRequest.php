<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'admin_id'     => 'required|integer|min:2',
            'password'	=>'sometimes|min:6',
            'confirm_password' =>'same:password',
            'role_id'	=>'sometimes|integer',
            'admin_status'	=>'sometimes|integer',

        ];
    }
}
