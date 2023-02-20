<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;

interface FraisEstimatorInterface
{
    public function estimate(Estimation $estimation): Estimation;
}
