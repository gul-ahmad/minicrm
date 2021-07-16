<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;


class StoreCompanyRequest extends FormRequest
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
            'name' =>'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:companies,email,' . $this->id,
           'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=100,min_height=100',
           //   'logo' => 'nullable|sometimes|image|mimes:jpg,png,jpeg,gif,svg|dimensions:max_width=100,max_height=100',
  
            'website' => 'nullable|string|max:50'
        ];
        
    }
    public function messages()
    {
        return [
            'logo.dimensions' => 'Logo must be atleast 100*100px',
            
        ];
    }






}
