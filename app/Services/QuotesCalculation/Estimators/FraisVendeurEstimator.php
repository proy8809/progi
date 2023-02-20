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
     * @param Estimation $estimation
     * @return float
     */
    private function _estimateFraisVendeur(Estimation $estimation): float {
        /** @var Estimation $estimation */
        $vehicleValue = $estimation->getRemainingBudget() / (1 + ($this->getVendeurPrct() / 100));
        return $this->getVendeurAccurateAmount($vehicleValue);
    }

    /**
     * Estime le frais spécial du vendeur d'un budget donné
     * @param float $budget
     * @param array $estimations
     * @return array
     */
    public function estimate(Estimation $estimation): Estimation
    {
        return $estimation->setFraisVendeur(
            $this->_estimateFraisVendeur($estimation)
        );
    }
}
