<?php
namespace App\Services\QuotesCalculation\Entities\Estimation;

interface EstimationInterface
{
    public function setFraisEntreposage(float $frais): EstimationInterface;
    public function setFraisAssociation(float $frais): EstimationInterface;
    public function setFraisUtilisation(float $frais): EstimationInterface;
    public function setFraisVendeur(float $frais): EstimationInterface;

    public function getFraisEntreposage(): float;
    public function getFraisAssociation(): float;
    public function getFraisUtilisation(): float;
    public function getFraisVendeur(): float;

    public function getSumFrais(): float;

    public function isWithinBudget(float $budget, float $addedFrais = 0): bool;
}
