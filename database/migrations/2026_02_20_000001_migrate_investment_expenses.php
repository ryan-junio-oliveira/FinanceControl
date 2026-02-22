<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // move any expenses categorized as investments into new investments table
        if (Schema::hasTable('expenses') && Schema::hasTable('investments')) {
            $rows = DB::table('expenses')
                ->join('categories', 'categories.id', '=', 'expenses.category_id')
                ->where('categories.name', 'Investimentos')
                ->select('expenses.*')
                ->get();

            foreach ($rows as $r) {
                DB::table('investments')->insert([
                    'organization_id' => $r->organization_id,
                    'name' => $r->name,
                    'amount' => $r->amount,
                    'fixed' => $r->fixed,
                    'transaction_date' => $r->transaction_date,
                    'monthly_financial_control_id' => $r->monthly_financial_control_id,
                    'created_at' => $r->created_at,
                    'updated_at' => $r->updated_at,
                ]);
            }

            // remove the migrated expenses so they are not double counted
            if ($rows->isNotEmpty()) {
                $ids = $rows->pluck('id')->all();
                DB::table('expenses')->whereIn('id', $ids)->delete();
            }
        }
    }

    public function down(): void
    {
        // on rollback we could move entries back but this is risky; skip
    }
};