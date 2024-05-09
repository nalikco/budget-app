<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = config('currencies');

        $currencyIsoCode = Arr::random(array_keys($currencies));
        $currency = $currencies[$currencyIsoCode];

        return [
            'iso_code' => $currencyIsoCode,
            'name' => $currency['name'],
            'format' => $currency['format'],
        ];
    }
}
