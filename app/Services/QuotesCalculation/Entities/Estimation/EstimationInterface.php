<?php
namespace App\Services\QuotesCalculation\Entities\Estimation;

interface EstimationInterface
{
    public function setFraisEntreposage(float $frais): EstimationInterface;
    public function setFraisAssociation(float $frais): EstimationInterface;
    public function setFraisUtilisation(float $frais): EstimationInterface;
    public function setFraisVendeur(float $frais): EstimationInterface;
    public function setBudget(float $budget): EstimationInterface;

    public function recalibrateFrais(): EstimationInterface;
    public function estimateVehicleAmount(): void;

    public function getSumFrais(): float;
    public function getRemainingBudget(): float;

    public function toArray(): array;

}
