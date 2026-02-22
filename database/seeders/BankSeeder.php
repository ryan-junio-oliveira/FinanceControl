<?php

namespace Database\Seeders;

use App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankModel as Bank;
use App\Modules\Shared\Domain\Enums\BankEnum;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = BankEnum::cases();
        usort($banks, fn($a, $b) => strcmp($a->value, $b->value));
        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank->value],
                ['name' => $bank->value, 'color' => $bank->color()]
            );
        }
    }
}

