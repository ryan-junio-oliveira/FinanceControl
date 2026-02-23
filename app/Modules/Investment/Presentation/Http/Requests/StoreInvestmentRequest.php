<?php

namespace App\Modules\Investment\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreInvestmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orgId = Auth::user()->organization_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['nullable', 'date'],
            'fixed' => ['sometimes', 'boolean'],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'investment');
                }),
            ],
        ];
    }
}
