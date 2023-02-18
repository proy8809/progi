<?php

namespace App\Services\QuotesCalculation\Entities\EstimationComputing;

use App\Services\QuotesCalculation\Collections\AssociationForks\AssociationForkCollection;
use App\Services\QuotesCalculation\Entities\Estimation\EstimationInterface;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class EstimationComputing implements EstimationComputingInterface
{
    use QuotesCalculationUtilities;

    private float $_budget = 0;
    private float $_fraisEntreposage = 0;
    private float $_fraisAssociation = 0;
    private float $_fraisUtilisation = 0;
    private float $_fraisVendeur = 0;
    private float $_valueVehicle = 0;

    /**
     * Cette classe effectue un nouveau calcul de tous les frais, étant donné que les valeurs préalables n'étaient que des estimations
     * On se sert du montant du véhicule trouvé afin d'effectuer à nouveau tous les calculs
     * On effectue les opérations dans l'ordre inverse
     * @param EstimationInterface $estimation
     * @param float $budget
     */
    public function __construct(EstimationInterface $estimation, float $budget)
    {
        $this->_budget = $budget;

        // On détermine la valeur du véhicule à l'aide des frais estimés
        $valueVehicle = $this->_budget - $estimation->getSumFrais();
        $this->_valueVehicle = $valueVehicle >= 0 ? $valueVehicle : 0;

        // Calcul du frais du vendeur
        $this->_fraisVendeur = $this->getVendeurAccurateAmount($this->_valueVehicle);
        // Calcul du frais d'association
        $this->_fraisAssociation = (new AssociationForkCollection())->getAccurateForkAmount($this->_valueVehicle);
        // Calcul du frais d'utilisation
        $this->_fraisUtilisation = $this->getUtilisationAccurateAmount($this->_valueVehicle);
        // Calcul du frais d'entreposage
        $this->_fraisEntreposage = $estimation->getFraisEntreposage();
    }

    /**
     * Est-ce que les données sont valides et respectent le budget?
     * @param float $budget
     * @return bool
     */
    public function isValid(float $budget): bool {
        return $budget >= (
            $this->_valueVehicle +
            $this->_fraisEntreposage +
            $this->_fraisUtilisation +
            $this->_fraisAssociation +
            $this->_fraisVendeur
        );
    }

    /**
     * Retour des valeurs sous forme d'array
     * @return array
     */
    public function toArray(): array {
        return [
            'entreposage' => $this->_fraisEntreposage,
            'utilisation' => $this->_fraisUtilisation,
            'association' => $this->_fraisAssociation,
            'vendeur' => $this->_fraisVendeur,
            'value' => $this->_valueVehicle
        ];
    }
}
