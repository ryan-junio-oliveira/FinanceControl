<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyFinancialControl extends Model
{
    protected $fillable = [
        'month',
        'year',
        'organization_id',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
