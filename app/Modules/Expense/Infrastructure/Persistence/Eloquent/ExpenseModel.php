<?php

namespace App\Modules\Expense\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\EnsuresMonthlyControl;

class ExpenseModel extends Model
{
    use EnsuresMonthlyControl;
    protected $table = 'expenses';

    protected $fillable = [
        'name',
        'amount',
        'fixed',
        'transaction_date',
        'monthly_financial_control_id',
        'credit_card_id',
        'category_id',
        'organization_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel::class, 'category_id');
    }
}
