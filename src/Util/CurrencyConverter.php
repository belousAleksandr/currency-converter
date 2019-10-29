<?php

declare(strict_types=1);

namespace App\Util;


use App\Exception\InvalidCurrencySource;
use App\Util\CurrencySources\CurrencySourceInterface;

class CurrencyConverter
{
    /** @var CurrencySourceInterface[]|iterable */
    private $sources;

    public function __construct(iterable $sources)
    {
        $this->sources = $sources;
    }

    /**
     * Execute exchange currency by provided request
     *
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return float
     * @throws InvalidCurrencySource
     */
    public function exchange(CurrencyExchangeRequest $currencyExchangeRequest): float
    {
        foreach ($this->sources as $currencySource) {
            if ($currencySource->getName() === $currencyExchangeRequest->getSource()) {
                return $currencySource->exchange($currencyExchangeRequest);
            }
        }

        throw new InvalidCurrencySource(sprintf('Currency source with name %s does not exist.', $currencyExchangeRequest->getSource()));
    }
}