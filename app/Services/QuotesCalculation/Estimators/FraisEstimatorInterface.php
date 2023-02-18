<?php
namespace App\Services\QuotesCalculation\Estimators;

interface FraisEstimatorInterface
{
    public function estimate(float $budget, array $estimations): array;
}
