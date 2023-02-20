<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisUtilisationEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Estime le frais d'utilisation pour un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(Estimation $estimation): Estimation
    {
        // On affecte la frais d'utilisation correspondant au budget restant
        return $estimation->setFraisUtilisation(
            $this->getUtilisationAccurateAmount($estimation->getRemainingBudget())
        );
    }
}
