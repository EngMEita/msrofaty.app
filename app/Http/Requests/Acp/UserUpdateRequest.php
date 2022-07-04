<?php

namespace App\Http\Requests\Acp;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email',  Rule::unique('users', 'email')->ignore($this->user()->id)],
            'password' => ['sometimes', 'nullable', 'min:8'],
        ];
    }
}
