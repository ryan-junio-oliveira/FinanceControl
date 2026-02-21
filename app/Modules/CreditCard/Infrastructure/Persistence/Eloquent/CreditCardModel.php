<?php

namespace App\Modules\CreditCard\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CreditCardModel extends Model
{
    protected $table = 'credit_cards';

    // sync with migration fields; repository currently only uses name/org,
    // but the model supports all attributes for convenience in controllers.
    protected $fillable = [
        'name',
        'organization_id',
        'bank_id',
        'bank',
        'statement_amount',
        'paid',
        'paid_at',
        'limit',
        'closing_day',
        'due_day',
        'is_active',
        'color',
    ];
    public function bank()
    {
        return $this->belongsTo(\App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankModel::class, 'bank_id');
    }

    public function organization()
    {
        return $this->belongsTo(\App\Modules\Organization\Infrastructure\Persistence\Eloquent\OrganizationModel::class, 'organization_id');
    }
}
