<?php

namespace App\Http\Requests;

use App\Rules\CharacterExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFavoriteRequest extends FormRequest
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
            'ref_api' => [
                'required',
                'numeric',
                Rule::unique('favorites')->where(fn ($query) => $query->where('ref_api', $this->ref_api)->where('user_id', Auth::user()->id)),
                new CharacterExists
                ]
        ];
    }

    public function attributes()
    {
        $attributes = [
            "ref_api"  => __('character'),
        ];

        return $attributes;
    }

    public function messages()
    {
        $messages = [
            "ref_api.unique"  => __('The character has already been added to favorites'),
        ];

        return $messages;
    }


}
