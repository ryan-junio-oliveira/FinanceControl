<?php

namespace App\Modules\Budget\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BudgetModel extends Model
{
    protected $table = 'budgets';

    protected $fillable = [
        'name',
        'amount',
        'start_date',
        'end_date',
        'category_id',
        'is_active',
        'organization_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}
