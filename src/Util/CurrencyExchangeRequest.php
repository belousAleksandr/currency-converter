<?php

declare(strict_types=1);

namespace App\Util;


class CurrencyExchangeRequest
{
    /** @var string|null */
    private $currencyFrom;
    /** @var string|null */
    private $currencyTo;
    /** @var float|null */
    private $amount;
    /** @var string|null */
    private $source;

    /**
     * @return null|string
     */
    public function getCurrencyFrom():? string
    {
        return $this->currencyFrom;
    }

    /**
     * @param null|string $currencyFrom
     */
    public function setCurrencyFrom(string $currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }

    /**
     * @return null|string
     */
    public function getCurrencyTo():? string
    {
        return $this->currencyTo;
    }

    /**
     * @param null|string $currencyTo
     */
    public function setCurrencyTo(string $currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }

    /**
     * @return float|null
     */
    public function getAmount():? float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return null|string
     */
    public function getSource():? string
    {
        return $this->source;
    }

    /**
     * @param null|string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }
}