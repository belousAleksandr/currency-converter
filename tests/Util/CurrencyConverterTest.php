<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Exception\InvalidCurrencySource;
use App\Util\CurrencyConverter;
use App\Util\CurrencyExchangeRequest;
use App\Util\CurrencySources\CurrencySourceInterface;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    public function testExchangeValidRequest()
    {
        $testSourceName = 'testSource';
        $testValue = 20;
        $sourceMock = $this->createMock(CurrencySourceInterface::class);
        $sourceMock->method('exchange')->willReturn($testValue);
        $sourceMock->method('getName')->willReturn($testSourceName);
        $requestMock = $this->createMock(CurrencyExchangeRequest::class);
        $requestMock->method('getSource')->willReturn($testSourceName);
        $currencyConverter = new CurrencyConverter([$sourceMock]);
        $result = $currencyConverter->exchange($requestMock);

        $this->assertEquals($testValue, $result);
    }

    public function testInvalidSource()
    {
        $this->expectException(InvalidCurrencySource::class);
        $testValue = 20;
        $sourceMock = $this->createMock(CurrencySourceInterface::class);
        $sourceMock->method('exchange')->willReturn($testValue);
        $sourceMock->method('getName')->willReturn('testSource');
        $requestMock = $this->createMock(CurrencyExchangeRequest::class);
        $requestMock->method('getSource')->willReturn('testSource2');
        $currencyConverter = new CurrencyConverter([$sourceMock]);
        $currencyConverter->exchange($requestMock);
    }
}