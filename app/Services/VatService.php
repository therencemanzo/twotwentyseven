<?php

namespace App\Services;

class VatService
{
    private static $instance = null;
    private $vatPercentage;

    /**
     * Private constructor to prevent direct instantiation.
     *
     * @param float $vatPercentage The VAT percentage (e.g., 20 for 20%).
     */
    private function __construct(float $vatPercentage)
    {
        $this->vatPercentage = $vatPercentage;
    }

    /**
     * Get the singleton instance of the VatService.
     *
     * @param float $vatPercentage The VAT percentage.
     * @return self
     */
    public static function getInstance(float $vatPercentage = 20): self
    {
        // If the instance doesn't exist or the VAT percentage has changed, create a new instance
        if (self::$instance === null || self::$instance->getVatPercentage() !== $vatPercentage) {
            self::$instance = new self($vatPercentage);
        }

        return self::$instance;
    }

    /**
     * Add VAT to a value.
     *
     * @param float $value The original value.
     * @return float The value including VAT.
     */
    public function addVat(float $value): float
    {
        $vatAmount = $this->calculateVatAmount($value);
        return $value + $vatAmount;
    }

    /**
     * Calculate the VAT portion of a value.
     *
     * @param float $value The original value.
     * @return float The VAT amount.
     */
    public function calculateVatAmount(float $value): float
    {
        return $value * ($this->vatPercentage / 100);
    }

    /**
     * Get the VAT percentage.
     *
     * @return float The VAT percentage.
     */
    public function getVatPercentage(): float
    {
        return $this->vatPercentage;
    }
}