<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsers extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'regex:/^[a-zA-Z\s]*$/','unique:users'],
            'email' => ['required','unique:users'],
            'phone' => ['required','unique:users'],
            'account_type' => ['sometimes'],
            'notes' => ['sometimes']
        ];
    }
}
