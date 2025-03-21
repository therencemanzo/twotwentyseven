<?php

use App\Services\VatService;

test('VatService calculates VAT amount correctly', function () {
    $vatService = VatService::getInstance(20); // 20% VAT

    expect($vatService->calculateVatAmount(100))->toBe(20.0);
    expect($vatService->calculateVatAmount(200))->toBe(40.0);
});

test('VatService adds VAT to a value correctly', function () {
    $vatService = VatService::getInstance(20); // 20% VAT

    expect($vatService->addVat(100))->toBe(120.0);
    expect($vatService->addVat(200))->toBe(240.0);
});

test('VatService is a singleton for the same VAT percentage', function () {
    $vatService1 = VatService::getInstance(20);
    $vatService2 = VatService::getInstance(20);

    expect($vatService1)->toBe($vatService2);
});

test('VatService uses the correct VAT percentage', function () {
    $vatService = VatService::getInstance(15); // 15% VAT

    expect($vatService->getVatPercentage())->toBe(15.0);
    expect($vatService->calculateVatAmount(100))->toBe(15.0);
    expect($vatService->addVat(100))->toBe(115.0);
});

test('VatService reinitializes for a new VAT percentage', function () {
    $vatService1 = VatService::getInstance(20); // 20% VAT
    $vatService2 = VatService::getInstance(15); // 15% VAT

    expect($vatService1)->not->toBe($vatService2);
    expect($vatService2->getVatPercentage())->toBe(15.0);
});