<?php

declare(strict_types=1);

namespace App\Util;

use App\Entity\ExchangeRate;
use App\Exception\InvalidCurrencySource;
use App\Repository\ExchangeRateRepository;
use App\Util\CurrencySources\CurrencySourceInterface;
use Doctrine\ORM\EntityManager;

class CurrencyConverter
{
    /** @var CurrencySourceInterface[]|iterable */
    private $sources;

    /** @var EntityManager */
    private $entityManager;

    /** @var ExchangeRateRepository */
    private $exchangeRateRepository;

    /**
     * CurrencyConverter constructor.
     * @param iterable $sources
     * @param EntityManager $entityManager
     */
    public function __construct(iterable $sources, EntityManager $entityManager)
    {
        $this->sources = $sources;
        $this->entityManager = $entityManager;
        $this->exchangeRateRepository = $entityManager->getRepository(ExchangeRate::class);
    }

    /**
     * Execute exchange currency by provided request
     *
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return float
     */
    public function exchange(CurrencyExchangeRequest $currencyExchangeRequest): float
    {
        $course = $this->getCourse($currencyExchangeRequest);

        return $course * $currencyExchangeRequest->getAmount();
    }

    /**
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return mixed
     * @throws InvalidCurrencySource
     */
    protected function getCourse(CurrencyExchangeRequest $currencyExchangeRequest)
    {
        /** @var ExchangeRate $exchangeRate */
        if ($exchangeRate = $this->getCourseFromDatabase($currencyExchangeRequest)) {
            return $exchangeRate->getCourse();
        }

        foreach ($this->sources as $currencySource) {
            if ($currencySource->getName() === $currencyExchangeRequest->getSource()) {
                $course = $currencySource->getCourse($currencyExchangeRequest);

                $this->saveCourse($course, $currencyExchangeRequest->getSource(), $currencyExchangeRequest->getCurrencyFrom(), $currencyExchangeRequest->getCurrencyTo());

                return $course;
            }
        }

        throw new InvalidCurrencySource(sprintf('Currency source with name %s does not exist.', $currencyExchangeRequest->getSource()));
    }

    /**
     * @param CurrencyExchangeRequest $currencyExchangeRequest
     * @return ExchangeRate|null
     */
    protected function getCourseFromDatabase(CurrencyExchangeRequest $currencyExchangeRequest)
    {
        return $this->exchangeRateRepository->findSourceCourse(
            $currencyExchangeRequest->getSource(),
            $currencyExchangeRequest->getCurrencyFrom(),
            $currencyExchangeRequest->getCurrencyTo()
        );
    }

    /**
     * @param float $course
     * @param string $source
     * @param string $currencyFrom
     * @param string $currencyTo
     */
    protected function saveCourse(float $course, string $source, string $currencyFrom, string $currencyTo)
    {
        $exchangeRate = new ExchangeRate();
        $exchangeRate->setSource($source);
        $exchangeRate->setCourse($course);
        $exchangeRate->setCurrencyCodeFrom($currencyFrom);
        $exchangeRate->setCurrencyCodeTo($currencyTo);
        $exchangeRate->setCreatedAt(new \DateTime());
        $this->entityManager->persist($exchangeRate);
        $this->entityManager->flush();
    }
}