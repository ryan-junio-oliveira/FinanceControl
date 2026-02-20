<?php

namespace App\Modules\Organization\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class OrganizationModel extends Model
{
    protected $table = 'organizations';

    // archived_at is a nullable timestamp added in a later migration.  We
    // keep `archived_at` in the fillable list so controllers can set it when
    // archiving/unarchiving the organization.
    protected $fillable = ['name', 'archived_at'];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    // helper used by various blade templates (sidebar, headers) to
    // determine whether the org has been archived.
    public function isArchived(): bool
    {
        return ! empty($this->archived_at);
    }
}
