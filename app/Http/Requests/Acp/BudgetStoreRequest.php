<?php

namespace App\Http\Requests\Acp;

use Illuminate\Foundation\Http\FormRequest;

class BudgetStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'limit' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'notice' => ['required', 'numeric', 'between:-999.99,999.99'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
