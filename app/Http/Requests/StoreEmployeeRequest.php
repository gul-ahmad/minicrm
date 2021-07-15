<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'firstname' => 'required', 'string', 'max:22',
            'lastname' => 'required','string','max:22', 
            'company_id' => 'nullable',
            'email' => 'nullable','string', 'email', 'max:255', 'unique:employees',
            'phone' => 'nullable|regex:/[0-9]{13}/',


        ];
    }
}
