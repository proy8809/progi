<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisEntreposageEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Estime le frais d'entreposage pour un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(Estimation $estimation): Estimation
    {
        // On affecte le frais configuré pour l'entreposage
        return $estimation->setFraisEntreposage($this->getEntreposageAmount());
    }
}
