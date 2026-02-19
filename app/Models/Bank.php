<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name', 'color'];

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }
}
