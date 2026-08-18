<?php

namespace App\Http\Requests\Acp;

use Illuminate\Foundation\Http\FormRequest;

class EntryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->household() !== null;
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
            'total_amount' => ['required', 'numeric', 'gt:0', 'between:0.01,9999999999.99'],
            'entry_type' => ['nullable', 'in:income,expense,transfer,refund,other'],
            'records' => ['nullable', 'array'],
            'records.*.account_id' => ['required', 'integer', 'exists:accounts,id'],
            'records.*.category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'records.*.type' => ['required', 'in:-1,1'],
            'records.*.value' => ['required', 'numeric', 'gt:0', 'between:0.01,999999.99'],
            'records.*.comment' => ['nullable', 'string', 'max:255'],
            'payment_splits' => ['nullable', 'array'],
            'payment_splits.*.account_id' => ['required', 'integer', 'exists:accounts,id'],
            'payment_splits.*.amount' => ['required', 'numeric', 'gt:0', 'between:0.01,9999999999.99'],
            'payment_splits.*.note' => ['nullable', 'string', 'max:255'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ];
    }
}
