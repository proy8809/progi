<?php
namespace App\Services\QuotesCalculation\Entities\Estimation;

use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

class Estimation implements EstimationInterface
{
    use QuotesCalculationUtilities;

    private float $_fraisEntreposage = 0;
    private float $_fraisAssociation = 0;
    private float $_fraisUtilisation = 0;
    private float $_fraisVendeur = 0;

    public function setFraisEntreposage(float $frais): EstimationInterface
    {
        $this->_fraisEntreposage = ( $frais >= 0 ) ? $frais : 0;
        return $this;
    }

    public function setFraisAssociation(float $frais): EstimationInterface
    {
        $this->_fraisAssociation = ( $frais >= 0 ) ? $frais : 0;
        return $this;
    }

    public function setFraisUtilisation(float $frais): EstimationInterface
    {
        $this->_fraisUtilisation = ( $frais >= 0 ) ? $frais : 0;
        return $this;
    }

    public function setFraisVendeur(float $frais): EstimationInterface
    {
        $this->_fraisVendeur = ( $frais >= 0 ) ? $frais : 0;
        return $this;
    }

    public function getFraisEntreposage(): float
    {
        return $this->_fraisEntreposage;
    }

    public function getFraisAssociation(): float
    {
        return $this->_fraisAssociation;
    }

    public function getFraisUtilisation(): float
    {
        return $this->_fraisUtilisation;
    }

    public function getFraisVendeur(): float
    {
        return $this->_fraisVendeur;
    }

    public function getSumFrais(): float
    {
        return $this->_fraisEntreposage + $this->_fraisAssociation + $this->_fraisUtilisation + $this->_fraisVendeur;
    }

    public function isWithinBudget(float $budget, float $addedFrais = 0): bool
    {
        return ( ( $budget - $this->getSumFrais() - $addedFrais ) >= 0 );
    }
}
