<?php
namespace App\Services\QuotesCalculation\Entities\Estimation;

use App\Services\QuotesCalculation\Collections\AssociationForks\AssociationForkCollection;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

/**
 * La classe Estimation garde en mémoire toutes les valeurs affectées aux différents frais
 * Elle se charge intrinsèquement d'assurer l'intégrité des données lorsqu'un frais est appliqué
 */
class Estimation implements EstimationInterface
{
    use QuotesCalculationUtilities;

    private float $_budget = 0;
    private float $_fraisEntreposage = 0;
    private float $_fraisAssociation = 0;
    private float $_fraisUtilisation = 0;
    private float $_fraisVendeur = 0;
    private float $_valueVehicle = 0;

    /**
     * Fonction privée permettant de vérifier la validité d'un frais avant de l'affecter dans l'instance
     * @param $nameFraisVar
     * @param $frais
     * @return void
     */
    private function _setFrais($nameFraisVar, $frais) {
        if ($frais < 0) {
            $frais = 0;
        }

        if ($this->getSumFrais() - $this->$nameFraisVar + $frais <= $this->_budget) {
            $this->$nameFraisVar = $frais;
        } else {
            $this->$nameFraisVar = 0;
        }
    }

    /**
     * Affectation du budget d'une estimation
     * @param float $budget
     * @return EstimationInterface
     */
    public function setBudget(float $budget): EstimationInterface
    {
        $this->_budget = $budget;
        return $this;
    }

    /**
     * Affectation d'une valeur pour le frais d'entreposage
     * @param float $frais
     * @return EstimationInterface
     */
    public function setFraisEntreposage(float $frais): EstimationInterface
    {
        $this->_setFrais('_fraisEntreposage', $frais);
        return $this;
    }

    /**
     * Affectation d'une valeur pour le frais d'association
     * @param float $frais
     * @return EstimationInterface
     */
    public function setFraisAssociation(float $frais): EstimationInterface
    {
        $this->_setFrais('_fraisAssociation', $frais);
        return $this;
    }

    /**
     * Affectation d'une valeur pour le frais d'utilisation
     * @param float $frais
     * @return EstimationInterface
     */
    public function setFraisUtilisation(float $frais): EstimationInterface
    {
        $this->_setFrais('_fraisUtilisation', $frais);
        return $this;
    }

    /**
     * Affectation d'une valeur pour le frais du vendeur
     * @param float $frais
     * @return EstimationInterface
     */
    public function setFraisVendeur(float $frais): EstimationInterface
    {
        $this->_setFrais('_fraisVendeur', $frais);
        return $this;
    }

    /**
     * Calibrage des frais une fois toutes les estimations de frais effectuées
     * Dans certains cas, il est possible que certaines valeurs de frais variables aient changé après toutes les affectations
     * @return EstimationInterface
     */
    public function recalibrateFrais(): EstimationInterface
    {
        $this->_setFrais('_fraisEntreposage', $this->getEntreposageAmount());
        $this->_setFrais('_fraisUtilisation', $this->getUtilisationAccurateAmount($this->_valueVehicle));
        $this->_setFrais('_fraisAssociation', (new AssociationForkCollection())->getAccurateForkAmount($this->_valueVehicle));
        $this->_setFrais('_fraisVendeur', $this->getVendeurAccurateAmount($this->_valueVehicle));
        return $this;
    }

    /**
     * Estimation de la valeur du véhicule en déduisant les frais estimés d'un budget donné
     * @return void
     */
    public function estimateVehicleAmount(): void
    {
        $this->_valueVehicle = $this->getRemainingBudget();
    }

    /**
     * Récupération de la somme de tous les frais
     * @return float
     */
    public function getSumFrais(): float
    {
        return $this->_fraisEntreposage + $this->_fraisAssociation + $this->_fraisUtilisation + $this->_fraisVendeur;
    }

    /**
     * Récupération du budget restant après l'application des frais estimés
     * @return float
     */
    public function getRemainingBudget(): float
    {
        $remaining = $this->_budget - $this->getSumFrais();
        if ($remaining < 0) {
            $remaining = 0;
        }
        return $remaining;
    }

    /**
     * Récupération des valeurs de l'instance "Estimation" sous forme d'array
     * @return array
     */
    public function toArray(): array
    {
        return [
            'entreposage' => $this->_fraisEntreposage,
            'utilisation' => $this->_fraisUtilisation,
            'association' => $this->_fraisAssociation,
            'vendeur' => $this->_fraisVendeur,
            'value' => $this->_valueVehicle,
            'total' => $this->_valueVehicle + $this->getSumFrais(),
            'budget' => $this->_budget
        ];
    }
}
