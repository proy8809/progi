<?php
namespace App\Services\QuotesCalculation\Entities\AssociationForks;

/**
 * Cette classe instancie les paramètres configurés d'une fourchette configurée pour les frais d'association
 */
class AssociationFork implements AssociationForkInterface
{
    private array $_params;

    /**
     * Prend en paramètre la configuration d'une fourchette donnée
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->_params = $params;
    }

    /**
     * Est-ce qu'un montant est dans la fourchette instanciée
     * @param float $amount
     * @return bool
     */
    public function isInFork(float $amount): bool
    {
        if ( isset($this->_params['gte']) ) {
            $conditionG = $amount >= $this->_params['gte'];
        } else if ( isset($this->_params['gt']) ) {
            $conditionG = $amount > $this->_params['gt'];
        }

        if ( isset($this->_params['lte']) ) {
            $conditionL = $amount <= $this->_params['lte'];
        } else if ( isset($this->_params['lt']) ) {
            $conditionL = $amount < $this->_params['lt'];
        }

        return $conditionG && $conditionL;
    }

    /**
     * Est-ce qu'un montant est inférieur à la limite inférieure de la fourchette instanciée
     * @param float $amount
     * @return bool
     */
    public function isUnder(float $amount): bool {
        if ( isset($this->_params['gte']) ) {
            $condition = $this->_params['gte'] <= $amount;
        } else if ( isset($this->_params['gt']) ) {
            $condition = $this->_params['gt'] < $amount;
        }

        return $condition;
    }

    /**
     * Est-ce qu'un montant est supérieur à la limite inférieure de la fourchette instanciée
     * @param float $amount
     * @return bool
     */
    public function isOver(float $amount): bool {
        if ( isset($this->_params['gte']) ) {
            $condition = $this->_params['gte'] >= $amount;
        } else if ( isset($this->_params['gt']) ) {
            $condition = $this->_params['gt'] >= $amount;
        }

        return $condition;
    }

    /**
     * Récupération de la valeur d'un paramètre donné
     * @param string $param
     * @return float
     */
    public function getParam(string $param): float {
        return $this->_params[$param] ?? 0;
    }
}
