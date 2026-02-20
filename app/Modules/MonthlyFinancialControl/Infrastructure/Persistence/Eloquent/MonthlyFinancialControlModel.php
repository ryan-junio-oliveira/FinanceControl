<?php

namespace App\Modules\MonthlyFinancialControl\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MonthlyFinancialControlModel extends Model
{
    // the migration created a table called "monthly_financial_controls"
    // (plural). ensure the model references the correct name.
    protected $table = 'monthly_financial_controls';

    protected $fillable = ['month', 'year', 'organization_id'];
} 
