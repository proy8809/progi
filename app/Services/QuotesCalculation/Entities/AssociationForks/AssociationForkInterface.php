<?php
namespace App\Services\QuotesCalculation\Entities\AssociationForks;

interface AssociationForkInterface
{
    public function __construct(array $params);
    public function isInFork(float $amount): bool;
    public function isOver(float $amount): bool;
    public function isUnder(float $amount): bool;
    public function getParam(string $param): float;
}
