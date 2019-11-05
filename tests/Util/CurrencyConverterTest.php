<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\ExchangeRate;
use App\Exception\InvalidCurrencySource;
use App\Repository\ExchangeRateRepository;
use App\Util\CurrencyConverter;
use App\Util\CurrencyExchangeRequest;
use App\Util\CurrencySources\CurrencySourceInterface;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    public function testExchangeValidRequestFromDatabase()
    {
        $testSourceName = 'testSource';
        $testAmount = 20;
        $course = 10;

        $requestMock = $this->createMock(CurrencyExchangeRequest::class);
        $requestMock->method('getAmount')->willReturn($testAmount);
        $requestMock->method('getSource')->willReturn($testSourceName);
        $requestMock->method('getCurrencyTo')->willReturn('USD');
        $requestMock->method('getCurrencyFrom')->willReturn('UAH');

        $exchangeRateMock = $this->createMock(ExchangeRate::class);
        $exchangeRateMock->method('getCourse')->willReturn($course);

        $exchangeRateRepositoryMock = $this->createMock(ExchangeRateRepository::class);
        $exchangeRateRepositoryMock
            ->method('findSourceCourse')
            ->with($requestMock->getSource(), $requestMock->getCurrencyFrom(), $requestMock->getCurrencyTo())
            ->willReturn($exchangeRateMock);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->method('getRepository')
            ->with(ExchangeRate::class)
            ->willReturn($exchangeRateRepositoryMock);

        $currencyConverter = new CurrencyConverter([], $entityManagerMock);
        $result = $currencyConverter->exchange($requestMock);

        $this->assertEquals(200, $result);
    }

    public function testExchangeValidRequest()
    {
        $testSourceName = 'testSource';
        $testAmount = 20;
        $course = 10;

        $requestMock = $this->createMock(CurrencyExchangeRequest::class);
        $requestMock->method('getAmount')->willReturn($testAmount);
        $requestMock->method('getSource')->willReturn($testSourceName);
        $requestMock->method('getCurrencyTo')->willReturn('USD');
        $requestMock->method('getCurrencyFrom')->willReturn('UAH');

        $entityManagerMock = $this->createMock(EntityManager::class);

        $exchangeRateRepositoryMock = $this->createMock(ExchangeRateRepository::class);
        $exchangeRateRepositoryMock
            ->method('findSourceCourse')
            ->with($requestMock->getSource(), $requestMock->getCurrencyFrom(), $requestMock->getCurrencyTo())
            ->willReturn(null);

        $entityManagerMock->method('getRepository')
            ->with(ExchangeRate::class)
            ->willReturn($exchangeRateRepositoryMock);

        $sourceMock = $this->createMock(CurrencySourceInterface::class);
        $sourceMock->method('getCourse')->willReturn($course);
        $sourceMock->method('getName')->willReturn($testSourceName);

        $currencyConverter = new CurrencyConverter([$sourceMock], $entityManagerMock);
        $result = $currencyConverter->exchange($requestMock);

        $this->assertEquals(200, $result);
    }

    public function testInvalidSource()
    {
        $testAmount = 20;
        $course = 10;

        $entityManagerMock = $this->createMock(EntityManager::class);
        $exchangeRateRepository = $this->createMock(ExchangeRateRepository::class);
        $entityManagerMock->method('getRepository')
            ->with(ExchangeRate::class)
            ->willReturn($exchangeRateRepository);
        $this->expectException(InvalidCurrencySource::class);

        $sourceMock = $this->createMock(CurrencySourceInterface::class);
        $sourceMock->method('getCourse')->willReturn($course);
        $sourceMock->method('getName')->willReturn('testSource');

        $requestMock = $this->createMock(CurrencyExchangeRequest::class);
        $requestMock->method('getAmount')->willReturn($testAmount);
        $requestMock->method('getSource')->willReturn('testSource2');
        $requestMock->method('getCurrencyTo')->willReturn('USD');
        $requestMock->method('getCurrencyFrom')->willReturn('UAH');

        $currencyConverter = new CurrencyConverter([$sourceMock], $entityManagerMock);
        $currencyConverter->exchange($requestMock);
    }
}