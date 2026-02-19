<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['name' => 'PicPay',         'color' => '#21C25E'],
            ['name' => 'Caixa',          'color' => '#0066B3'],
            ['name' => 'Banco do Brasil','color' => '#FFCC00'],
            ['name' => 'Santander',      'color' => '#EC0000'],
            ['name' => 'Inter',          'color' => '#FF7A00'],
            ['name' => 'Nubank',         'color' => '#8A05BE'],
            ['name' => 'Bradesco',       'color' => '#CC092F'],
            ['name' => 'Sicoob',         'color' => '#00A859'],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank['name']], // chave única lógica
                $bank
            );
        }
    }
}
