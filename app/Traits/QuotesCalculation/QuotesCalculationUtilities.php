<?php
namespace App\Traits\QuotesCalculation;

/**
 * Contient des fonctions utilitaires afin de centraliser/simplifier certaines opérations réccurentes, notamment
 * la récupération de certaines variables de configuration
 */
trait QuotesCalculationUtilities
{
    /**
     * Récupération du montant consacré aux frais d'entreposage
     * @return float
     */
    public function getEntreposageAmount(): float {
        return config('quote_calculation')['entreposage']['amount'];
    }

    /**
     * Récupération du montant minimal consacré aux frais d'utilisation
     * @return float
     */
    public function getUtilisationMin(): float {
        return config('quote_calculation')['utilisation']['min'];
    }

    /**
     * Récupération du montant maximal consacré aux frais d'utilisation
     * @return float
     */
    public function getUtilisationMax(): float {
        return config('quote_calculation')['utilisation']['max'];
    }

    /**
     * Récupération du pourcentage du frais d'utilisation
     * @return float
     */
    public function getUtilisationPrct(): float {
        return config('quote_calculation')['utilisation']['prct'];
    }

    /**
     * Récupération du montant calibré pour le frais d'utilisation (tenant compte de min et max)
     * @param float $vehicleValue
     * @return float
     */
    public function getUtilisationAccurateAmount(float $vehicleValue): float {
        $frais = $vehicleValue * ($this->getUtilisationPrct() / 100);
        if ($frais < $this->getUtilisationMin()) {
            $frais = $this->getUtilisationMin();
        } else if ($frais > $this->getUtilisationMax()) {
            $frais = $this->getUtilisationMax();
        }
        return $frais;
    }

    /**
     * Récupération des fourchettes configurées pour les frais d'association
     * @return array
     */
    public function getAssociationForks(): array {
        return config('quote_calculation')['association']['forks'];
    }

    /**
     * Récupération du pourcentage du frais du vendeur
     * @return float
     */
    public function getVendeurPrct(): float {
        return config('quote_calculation')['vendeur']['prct'];
    }

    /**
     * Calcul et récupération du montant du frais du vendeur pour une valeur de véhicule donnée
     * @param float $vehicleValue
     * @return float
     */
    public function getVendeurAccurateAmount(float $vehicleValue): float {
        $decimalPrctVendeur = ($this->getVendeurPrct() / 100);
        return (float) number_format($decimalPrctVendeur * $vehicleValue, 2, '.', '');
    }
}
