<?php

namespace App\Services\QuotesCalculation\Entities\EstimationComputing;

use App\Services\QuotesCalculation\Entities\Estimation\EstimationInterface;

interface EstimationComputingInterface
{
    public function __construct(EstimationInterface $estimation, float $budget);

    public function isValid(float $budget): bool;
    public function toArray(): array;
}
