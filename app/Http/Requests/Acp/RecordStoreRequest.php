<?php

namespace App\Http\Requests\Acp;

use Illuminate\Foundation\Http\FormRequest;

class RecordStoreRequest extends FormRequest
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
            'entry_id' => ['required', 'integer', 'exists:entries,id'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'type' => ['required', 'in:-1,1'],
            'value' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'category_id' => ['integer', 'exists:categories,id'],
            'comment' => ['string', 'max:255'],
        ];
    }
}
