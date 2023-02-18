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
    public function estimate(float $budget, array $estimations): array
    {
        // Calculation du frais spéculé
        $frais = $this->getEntreposageAmount();

        // On s'assure que le frais entre dans le budget
        if ( $budget < $this->getEntreposageAmount() ) {
            $frais = 0;
        }

        // On empile l'estimation dans la liste de sortie
        return [ (new Estimation())->setFraisEntreposage( $frais ) ];
    }
}
