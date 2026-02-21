<?php

namespace App\Modules\Recipe\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $orgId = Auth::user()->organization_id;

        return [
            'name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'nullable|date',
            'fixed' => 'boolean',
            'monthly_financial_control_id' => [
                'nullable',
                'integer',
                Rule::exists('monthly_financial_controls', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId);
                }),
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'recipe');
                }),
            ],
            'received' => 'boolean',
            'received_at' => 'nullable|date',
        ];
    }
}
