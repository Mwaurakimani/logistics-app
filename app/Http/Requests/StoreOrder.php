<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'customer_name' => ['required','regex:/^[a-zA-Z\s]*$/'] ,
            'contact_name' => ['required','regex:/^[a-zA-Z\s]*$/'] ,
            'contact_phone' => ['required'] ,
            'lpo_number' => ['required'] ,
            'lpo_value' => ['required'] ,
            'user_id' => ['sometimes'] ,
            'proposed_delivery_date' => ['sometimes'] ,
            'contact_address' => ['sometimes'] ,
            'comments' => ['sometimes'] ,
            'payment_status' => ['sometimes'] ,
            'delivery_status' => ['sometimes'] ,
        ];
    }
}
