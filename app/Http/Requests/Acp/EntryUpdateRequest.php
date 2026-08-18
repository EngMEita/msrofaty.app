<?php

namespace App\Http\Requests\Acp;

use Illuminate\Foundation\Http\FormRequest;

class EntryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->household() !== null
            && $this->user()->can('update', $this->route('entry'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'note' => ['string'],
            'records' => ['required', 'array', 'min:1'],
            'records.*.account_id' => ['required', 'integer', 'exists:accounts,id'],
            'records.*.category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'records.*.type' => ['required', 'in:-1,1'],
            'records.*.value' => ['required', 'numeric', 'gt:0', 'between:0.01,999999.99'],
            'records.*.comment' => ['nullable', 'string', 'max:255'],
        ];
    }
}
