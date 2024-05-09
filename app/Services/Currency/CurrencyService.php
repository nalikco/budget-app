<?php

namespace App\Services\Currency;

use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Models\Currency;

class CurrencyService
{
    /**
     * Finds a currency by its ISO code.
     *
     * @param  string  $isoCode  The ISO code of the currency.
     * @return Currency The found currency.
     *
     * @throws CurrencyNotFoundException If no currency with the specified ISO code is found.
     */
    public function findByIsoCode(string $isoCode): Currency
    {
        $currency = Currency::query()
            ->where('iso_code', $isoCode)
            ->first();
        if (is_null($currency)) {
            throw new CurrencyNotFoundException();
        }

        return $currency;
    }
}
