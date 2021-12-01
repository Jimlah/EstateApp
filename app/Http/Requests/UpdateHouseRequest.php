<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'A description is required',
            'description.max' => 'A description must be less than 255 characters',
            'address.required' => 'An address is required',
            'address.max' => 'An address must be less than 255 characters',
            'category.required' => 'A category is required',
            'category.max' => 'A category must be less than 255 characters',
        ];
    }
}
