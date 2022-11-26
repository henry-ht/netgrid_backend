<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->id == $this->user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => 'sometimes|required|string',
            'email'     => 'sometimes|required|email|unique:users,email,'.Auth::user()->id,
            'password'  => 'sometimes|required|max:50|min:6|confirmed',
            'city'      => 'sometimes|required|string|max:150|min:6',
            'address'   => 'sometimes|required|string|max:150|min:6',
            'birthdate' => 'sometimes|required|date|before:'.Carbon::now()->subYears(18)->format('Y-m-d')
        ];
    }

    /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'status'    => false,
            'message'   => $validator->errors(),
        ], 422));
    }
}
