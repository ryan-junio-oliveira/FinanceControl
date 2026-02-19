<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    protected $fillable = [
        'name', 'bank_id', 'bank', 'statement_amount', 'limit',
        'closing_day', 'due_day', 'is_active', 'color', 'organization_id'
    ];

    protected $casts = [
        'statement_amount' => 'decimal:2',
        'limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
