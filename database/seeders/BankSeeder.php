<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Bank\Infrastructure\Persistence\Eloquent\BankModel as Bank;
use App\Enums\BankEnum;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        foreach (BankEnum::cases() as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank->value],
                ['name' => $bank->value, 'color' => $bank->color()]
            );
        }
    }
}

