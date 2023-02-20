<?php
namespace App\Services\QuotesCalculation\Collections\AssociationForks;

interface AssociationForkCollectionInterface
{
    public function getAccurateForkAmount(float $inAmount): float;
}
