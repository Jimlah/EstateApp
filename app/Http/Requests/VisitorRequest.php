<?php

namespace App\Http\Requests;

use App\Models\Estate;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|max:255',
            'estate_id' => 'sometimes|exists:estates,id',
            'user_id' => 'sometimes|exists:users,id',
            'sent_by' => 'sometimes',
        ];
    }

    public function afterValidation()
    {

        if(request()->user() instanceof Manager ) {
            $this->merge([
                'sent_by' => Estate::class,
            ]);
        }

        if(request()->user() instanceof User ) {
            $this->merge([
                'sent_by' => User::class,
            ]);
        }

    }
}
