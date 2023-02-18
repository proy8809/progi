<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisUtilisationEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Estime les frais d'utilisation d'un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(float $budget, array $estimations): array
    {
        $outEstimations = [];
        foreach ($estimations as $estimation) {
            /** @var Estimation $estimation */
            // Calculation du frais spéculé
            $frais = $this->getUtilisationAccurateAmount($budget - $estimation->getSumFrais());

            // On s'assure que le frais entre dans le budget
            if (!$estimation->isWithinBudget($budget, $frais)) {
                $frais = 0;
            }

            // On empile l'estimation dans la liste de sortie
            $outEstimations[] = (clone $estimation)->setFraisUtilisation($frais);
        }

        return $outEstimations;
    }
}
