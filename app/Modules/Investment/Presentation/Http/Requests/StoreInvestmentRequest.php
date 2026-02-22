<?php

namespace App\Modules\Investment\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['nullable', 'date'],
            'fixed' => ['sometimes', 'boolean'],
        ];
    }
}
