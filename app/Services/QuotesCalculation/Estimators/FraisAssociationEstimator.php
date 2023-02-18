<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\AssociationForks\AssociationFork;
use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisAssociationEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Estime les frais d'association d'un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(float $budget, array $estimations): array
    {
        $outEstimations = [];

        // Récupération des fourchettes configurées pour le frais d'association
        $allForks = $this->getAssociationForks();

        // On itère chaque estimation
        foreach ($estimations as $estimation) { /** @var Estimation $estimation */
            // On itère chacune des fourchettes
            foreach ($allForks as $arrFork) {
                // Objet manipulant les opérations relatives à une fourchette configurée pour le frais association
                $fork = new AssociationFork($arrFork);

                // On ne tient pas compte de la fourchette si le budget est inférieur à sa limite inférieure
                if ($fork->isUnder($budget - $estimation->getSumFrais())) {
                    break;
                }

                $frais = $arrFork['amount'];

                // On s'assure que le frais entre dans le budget
                if (!$estimation->isWithinBudget($budget, $frais)) {
                    $frais = 0;
                }

                // On empile l'estimation dans la liste de sortie
                $outEstimations[] = (clone $estimation)->setFraisAssociation($frais);
            }
        }

        // Il est théoriquement possible qu'aucun frais association n'ai correspondu au montant résiduel
        // Dans tel cas, on s'assure de retourner 0 comme frais d'association, et on évite de retourner un liste vide
        if ( empty($outEstimations) ) {
            $outEstimations[] = (clone $estimation)->setFraisAssociation(0);
        }

        return $outEstimations;
    }
}
