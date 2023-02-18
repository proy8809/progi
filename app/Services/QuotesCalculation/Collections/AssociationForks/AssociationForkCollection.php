<?php
namespace App\Services\QuotesCalculation\Collections\AssociationForks;

use App\Services\QuotesCalculation\Entities\AssociationForks\AssociationFork;
use App\Traits\QuotesCalculation\QuotesCalculationUtilities;

/**
 * Cette classe instancie une collection de différentes fourchettes configurées pour les frais d'association
 */
class AssociationForkCollection implements AssociationForkCollectionInterface
{
    use QuotesCalculationUtilities;

    private array $_forks = [];

    /**
     * On créé plusieurs objets "AssociationFork" pour chaque différente fourchette configurée
     */
    public function __construct()
    {
        foreach ($this->getAssociationForks() as $fork) {
            $this->_forks[] = new AssociationFork($fork);
        }
    }

    /**
     * Récupération du montant correspondant de la fourchette instanciée
     * @param float $budget
     * @return float
     */
    public function getAccurateForkAmount(float $budget): float {
        $amount = 0;
        foreach ($this->_forks as $fork) {
            /** @var AssociationFork $fork */
            if ($fork->isInFork($budget)) {
                $amount = $fork->getParam('amount');
            }
        }
        return $amount;
    }
}
