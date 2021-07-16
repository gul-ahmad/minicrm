<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;


class StoreEmployeeRequest extends FormRequest
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
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50', 
            'company_id' => 'nullable',
            'email' => 'nullable|string|email|max:50|unique:employees,email,' . $this->id,
            'phone' => 'nullable|regex:/[0-9]{13}/',


        ];
    }
}
