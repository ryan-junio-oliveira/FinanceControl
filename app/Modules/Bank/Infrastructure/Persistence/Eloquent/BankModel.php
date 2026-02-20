<?php

namespace App\Modules\Bank\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    protected $table = 'banks';

    protected $fillable = ['name', 'organization_id'];
}
