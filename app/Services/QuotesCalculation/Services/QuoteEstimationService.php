<?php
namespace App\Services\QuotesCalculation\Services;

use App\Services\QuotesCalculation\Entities\Estimation\Estimation;
use App\Services\QuotesCalculation\Entities\EstimationComputing\EstimationComputing;
use App\Services\QuotesCalculation\Entities\EstimationComputing\EstimationComputingInterface;
use App\Services\QuotesCalculation\Estimators\FraisAssociationEstimator;
use App\Services\QuotesCalculation\Estimators\FraisEntreposageEstimator;
use App\Services\QuotesCalculation\Estimators\FraisUtilisationEstimator;
use App\Services\QuotesCalculation\Estimators\FraisVendeurEstimator;
use Illuminate\Support\Collection;

/**
 * Classe contenante du service
 * C'est cette fonction qui harmonise les différentes opérations et retourne le nombre décimal correspondant
 * à la valeur maximale du véhicule
 */
class QuoteEstimationService implements QuoteEstimationServiceInterface
{
    public function __construct(
        private FraisEntreposageEstimator $_entreposageEstimator,
        private FraisUtilisationEstimator $_utilisationEstimator,
        private FraisAssociationEstimator $_associationEstimator,
        private FraisVendeurEstimator $_vendeurEstimator
    ) {}

    /**
     * Estimation du montant maximal d'un achat possible à l'aide d'un budget donné
     * @param float $budget
     * @return array
     */
    public function estimate(float $budget): array
    {
        // On instancie une estimation afin de commencer l'algorithme
        $estimation = new Estimation();
        $estimation->setBudget($budget);

        // On effectue les algorithmes d'estimation des différents frais
        $estimation = $this->_entreposageEstimator->estimate($estimation);
        $estimation = $this->_utilisationEstimator->estimate($estimation);
        $estimation = $this->_associationEstimator->estimate($estimation);
        $estimation = $this->_vendeurEstimator->estimate($estimation);

        // On estime la valeur du véhicule selon les estimations précédentes
        $estimation->estimateVehicleAmount();

        // On recalibre les frais, étant donné qu'il se puisse que les frais d'association et d'utilisation aient changé
        // suite à la déduction des frais estimés ultérieurement
        $estimation->recalibrateFrais();
        return $estimation->toArray();
    }
}
