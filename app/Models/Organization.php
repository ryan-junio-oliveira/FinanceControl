<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function monthlyFinancialControls()
    {
        return $this->hasMany(MonthlyFinancialControl::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
