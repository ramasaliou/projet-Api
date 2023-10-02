<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\validation\Validator;

class LogUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'email' => 'required|email|exists:users,email',
             'password'=>'required'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            
            'success'=>false,
            'error'=> true,
            'message'=>'Erreur de validation' ,
            'erorsList'=>$validator->errors()

    ]));
    }
    public function messages(){
        return [
          'email.required'=>'email non fourni',
          'email.email'=>'Adress email non  valide',
          'email.exists'=>'cette Adresse n\' existe pas',
          'password.required'=>'mot de pass non  fourni',
        ];
    }
}
