<?php

namespace App\Modules\Investment\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\EnsuresMonthlyControl;

class InvestmentModel extends Model
{
    use EnsuresMonthlyControl;

    protected $table = 'investments';

    protected $fillable = [
        'name',
        'amount',
        'fixed',
        'transaction_date',
        'organization_id',
        'category_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    protected $hidden = [
        'monthly_financial_control_id',
    ];

    /**
     * Category this investment belongs to (optional).
     */
    public function category()
    {
        return $this->belongsTo(\App\Modules\Admin\Infrastructure\Persistence\Eloquent\CategoryModel::class, 'category_id');
    }

    public static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->transaction_date)) {
                $model->transaction_date = now()->toDateString();
            }
        });
    }
}
