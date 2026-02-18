<?php

namespace App\Models\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\MonthlyFinancialControl;

trait EnsuresMonthlyControl
{
    /**
     * Boot the trait: ensure a MonthlyFinancialControl exists for transaction_date + organization_id
     * and set the `monthly_financial_control_id` automatically when missing.
     */
    protected static function bootEnsuresMonthlyControl()
    {
        static::saving(function ($model) {
            // Respect explicit selection from the caller
            if (!empty($model->monthly_financial_control_id)) {
                return;
            }

            // determine date (fallback to now)
            $date = null;
            if (!empty($model->transaction_date)) {
                $date = $model->transaction_date instanceof Carbon
                    ? $model->transaction_date
                    : Carbon::parse($model->transaction_date);
            } else {
                $date = Carbon::now();
            }

            // determine organization (prefer model value, fallback to authenticated user)
            $orgId = $model->organization_id ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->organization_id : null);
            if (empty($orgId)) {
                // nothing we can do without an organization
                return;
            }

            $mfc = MonthlyFinancialControl::firstOrCreate(
                [
                    'organization_id' => $orgId,
                    'month' => (int) $date->month,
                    'year' => (int) $date->year,
                ],
                []
            );

            $model->monthly_financial_control_id = $mfc->id;
        });
    }
}
