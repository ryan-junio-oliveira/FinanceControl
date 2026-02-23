<?php

namespace App\Modules\CreditCard\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCreditCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $orgId = Auth::user()->organization_id;

        return [
            'name' => 'required|string|max:191',
            'bank_id' => 'required|exists:banks,id',
            'statement_amount' => 'required|numeric|min:0',
            'limit' => 'nullable|numeric|min:0',
            'closing_day' => 'nullable|integer|between:1,31',
            'due_day' => 'nullable|integer|between:1,31',
            'color' => ['nullable','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active' => 'sometimes|boolean',
            'paid'      => 'sometimes|boolean',
        ];
    }
}
