<?php
namespace App\Services\QuotesCalculation\Services;

interface QuoteEstimationServiceInterface
{
    public function estimate(float $budget): array;
}
