<?php

namespace App\Modules\Budget\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreBudgetRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($q) use ($orgId) {
                    $q->where('organization_id', $orgId)->where('type', 'expense');
                }),
            ],
            'is_active' => 'boolean',
        ];
    }
}
