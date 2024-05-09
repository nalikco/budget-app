<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('currencies') as $isoCode => $currency) {
            Currency::query()->firstOrCreate(attributes: [
                'iso_code' => $isoCode,
            ], values: [
                'name' => $currency['name'],
                'format' => $currency['format'],
            ]);
        }
    }
}
