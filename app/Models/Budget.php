<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
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

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function spent(): float
    {
        $q = Expense::where('organization_id', $this->organization_id)
            ->whereBetween('transaction_date', [$this->start_date->format('Y-m-d'), $this->end_date->format('Y-m-d')]);

        if ($this->category_id) {
            $q->where('category_id', $this->category_id);
        }

        return (float) $q->sum('amount');
    }

    public function progressPercent(): float
    {
        if (!$this->amount || $this->amount == 0) return 0.0;
        return min(100.0, round(($this->spent() / $this->amount) * 100, 2));
    }
}
