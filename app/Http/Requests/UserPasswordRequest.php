<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules (User $user, Request $request)
    {
        
        $user_password = $this->route ('user')->password;
        $new_password = $this->input ('new_password');
        
        
        return [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user_password) {
                    if( !(Hash::check ($value, $user_password)) ){
                        $fail('Passwords do not match');
                    }
                }
                ],
            'new_password' => 'required',
            'confirm_new_password' => [
                'required',
                    function ($attribute, $value, $fail) use ($new_password) {
                            if($value != $new_password){
                                $fail('New Passwords do not Match');
                            }
                    }
                ],
        ];
    }
}