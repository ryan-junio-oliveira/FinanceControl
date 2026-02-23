<?php

namespace App\Modules\Admin\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    protected $table = 'banks';
    protected $fillable = ['name', 'color'];
}
