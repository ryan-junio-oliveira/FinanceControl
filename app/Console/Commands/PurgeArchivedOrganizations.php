<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organization;
use Carbon\Carbon;

class PurgeArchivedOrganizations extends Command
{
    protected $signature = 'organizations:purge-archived';
    protected $description = 'Remove permanently organizations archived more than 6 months ago.';

    public function handle()
    {
        $cutoff = Carbon::now()->subMonths(6);
        $toDelete = Organization::whereNotNull('archived_at')
            ->where('archived_at', '<=', $cutoff)
            ->get();

        $count = 0;
        foreach ($toDelete as $org) {
            $org->delete();
            $count++;
        }

        $this->info("Purged {$count} organizations archived before {$cutoff->toDateString()}");
        return 0;
    }
}
