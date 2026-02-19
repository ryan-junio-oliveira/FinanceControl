<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\EnsuresMonthlyControl;

class Expense extends Model
{
    use EnsuresMonthlyControl;

    protected $fillable = [
        'name',
        'amount',
        'fixed',
        'transaction_date',
        'monthly_financial_control_id',
        'credit_card_id',
        'organization_id',
        'category_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fixed' => 'boolean',
        'transaction_date' => 'date',
    ];

    public function monthlyFinancialControl()
    {
        return $this->belongsTo(MonthlyFinancialControl::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }
}
