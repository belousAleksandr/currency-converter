<?php

declare(strict_types=1);

namespace App\Util\CurrencySources;


use App\Exception\InvalidCurrencyCode;
use App\Util\Client;
use App\Util\CurrencyExchangeRequest;

class NBUCurrencySource implements CurrencySourceInterface
{
    private const SOURCE_DEFAULT_CURRENCY = 'UAH';

    /** @var Client */
    private $client;

    /**
     * NBUCurrencySource constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns source name
     * @return string
     */
    public function getName(): string
    {
        return 'NBU';
    }

    /**
     * Execute exchange currency by provided request
     *
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return float
     */
    public function getCourse(CurrencyExchangeRequest $currencyExchangeRequest): float
    {
        $fromRate = $this->getCurrencyRate($currencyExchangeRequest->getCurrencyFrom());
        $fromTo = $this->getCurrencyRate($currencyExchangeRequest->getCurrencyTo());
        $result = $fromRate / $fromTo;

        return round($result, 3);
    }

    /**
     * @param string $currencyCode
     * @return mixed
     * @throws InvalidCurrencyCode
     */
    protected function getCurrencyRate(string $currencyCode)
    {
        // Default currency rate is 1
        if ($currencyCode === self::SOURCE_DEFAULT_CURRENCY) {
            return 1;
        }

        $response = $this->client->get('https://old.bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json');
        $currenciesRates = json_decode((string)$response->getBody());
        foreach ($currenciesRates as $currenciesRateData) {
            if ($currenciesRateData->cc === $currencyCode) {
                return $currenciesRateData->rate;
            }
        }

        throw new InvalidCurrencyCode(sprintf('Currency code is not found %s', $currencyCode));
    }
}