<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'organization_id'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
