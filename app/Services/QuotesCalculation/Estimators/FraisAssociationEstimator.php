<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Collections\AssociationForks\AssociationForkCollection;
use App\Services\QuotesCalculation\Entities\AssociationForks\AssociationFork;
use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisAssociationEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Estime le frais d'association pour un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(Estimation $estimation): Estimation
    {
        // Collection des fourchettes configurées pour les frais d'association
        $forkCollection = new AssociationForkCollection();
        // On affecte le montant de la fourchette correspondante au montant restant
        return $estimation->setFraisAssociation(
            $forkCollection->getAccurateForkAmount($estimation->getRemainingBudget())
        );
    }
}
