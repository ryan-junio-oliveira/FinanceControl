<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isArchived(): bool
    {
        return !is_null($this->archived_at);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
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

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
