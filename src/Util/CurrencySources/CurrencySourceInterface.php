<?php

declare(strict_types=1);

namespace App\Util\CurrencySources;


use App\Util\CurrencyExchangeRequest;

interface CurrencySourceInterface
{
    /**
     * Returns source name
     * @return string
     */
    public function getName(): string;

    /**
     * Execute exchange currency by provided request
     *
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return float
     */
    public function exchange(CurrencyExchangeRequest $currencyExchangeRequest): float;
}