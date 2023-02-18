<?php
namespace App\Services\QuotesCalculation\Estimators;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class FraisVendeurEstimator implements FraisEstimatorInterface
{
    use QuotesCalculationUtilities;

    /**
     * Effectue l'approximation du frais spécial du vendeur en effectuant des règles d'algèbres élémentaires
     * B = Budget, FA = Frais ajoutés au préalable, PV = Pourcentage spécial du vendeur, VV = Valeur présumée du véhicule
     * VV + PV(VV) = (B - FA)
     * 1 + PV (VV) = (B - FA)
     * VV = (B - FA) / 1 + PV
     * Après avoir isolé VV, on effectue la multiplication du pourcentage du spécial du vendeur
     * @param float $budget
     * @param Estimation $estimation
     * @return float
     */
    private function _estimateFraisVendeur(float $budget, Estimation $estimation): float { /** @var Estimation $estimation */
        $remaining = $budget - $estimation->getSumFrais();
        $vehicleValue = $remaining / (1 + ($this->getVendeurPrct() / 100));
        return $this->getVendeurAccurateAmount($vehicleValue);
    }

    /**
     * Estime le frais spécial du vendeur d'un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(float $budget, array $estimations): array
    {
        $outEstimations = [];
        foreach ($estimations as $estimation) { /** @var Estimation $estimation */
            // On calcule le frais du vendeur
            $frais = $this->_estimateFraisVendeur($budget, $estimation);

            // On s'assure que le frais entre dans le budget
            if (!$estimation->isWithinBudget($budget, $frais)) {
                $frais = 0;
            }

            // On empile l'estimation dans la liste de sortie
            $outEstimations[] = (clone $estimation)->setFraisVendeur($frais);
        }
        return $outEstimations;
    }
}
