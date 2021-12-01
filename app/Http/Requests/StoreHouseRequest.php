<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
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
            'description' => 'required|max:255',
            'address' => 'required|max:255',
            'category' => 'required|max:255',
            'estate_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'estate_id.required' => 'Estate is required',
            'estate_id.integer' => 'Estate must be an integer',
        ];
    }
}
