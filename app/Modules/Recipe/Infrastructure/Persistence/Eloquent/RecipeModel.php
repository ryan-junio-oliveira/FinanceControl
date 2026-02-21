<?php

namespace App\Modules\Recipe\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\EnsuresMonthlyControl;

class RecipeModel extends Model
{
    use EnsuresMonthlyControl;
    protected $table = 'recipes';

    protected $fillable = [
        'name',
        'amount',
        'fixed',
        'transaction_date',
        'received',
        'received_at',
        'monthly_financial_control_id',
        'category_id',
        'organization_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'received' => 'boolean',
        'received_at' => 'date',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->transaction_date)) {
                $model->transaction_date = now()->toDateString();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(\App\Modules\Category\Infrastructure\Persistence\Eloquent\CategoryModel::class, 'category_id');
    }
}
