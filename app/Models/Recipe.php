<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'fixed',
        'transaction_date',
        'monthly_financial_control_id',
        'organization_id',
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
}
