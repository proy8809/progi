<?php
namespace App\Services\QuotesCalculation\Services;

use App\Services\QuotesCalculation\Entities\EstimationComputing\EstimationComputing;
use App\Services\QuotesCalculation\Entities\EstimationComputing\EstimationComputingInterface;
use App\Services\QuotesCalculation\Estimators\FraisAssociationEstimator;
use App\Services\QuotesCalculation\Estimators\FraisEntreposageEstimator;
use App\Services\QuotesCalculation\Estimators\FraisUtilisationEstimator;
use App\Services\QuotesCalculation\Estimators\FraisVendeurEstimator;
use Illuminate\Support\Collection;

class QuoteEstimationService implements QuoteEstimationServiceInterface
{
    public function __construct(
        private FraisEntreposageEstimator $_entreposageEstimator,
        private FraisUtilisationEstimator $_utilisationEstimator,
        private FraisAssociationEstimator $_associationEstimator,
        private FraisVendeurEstimator $_vendeurEstimator
    ) {}

    /**
     * Récupère la possibilité optimale (plus grand montant d'achat potentiel)
     * @param EstimationComputingInterface $possibility
     * @return EstimationComputing
     */
    private function _keepOptimalPossibility(Collection $possibilities): EstimationComputing {
        /** @var EstimationComputing $possibility */
        return $possibilities->sortByDesc(fn($possibility) => $possibility->toArray()['value'])->first();
    }

    /**
     * Estimation du montant maximal d'un achat possible à l'aide d'un budget donné
     * @param float $budget
     * @return array
     */
    public function estimate(float $budget): array
    {
        // On effectue les estimations
        $estimations = $this->_entreposageEstimator->estimate($budget, []);
        $estimations = $this->_utilisationEstimator->estimate($budget, $estimations);
        $estimations = $this->_associationEstimator->estimate($budget, $estimations);
        $estimations = $this->_vendeurEstimator->estimate($budget, $estimations);

        // On filtre seulement les estimations qui sont valides (dont le montant revérifié est toujours abordable sous le budget donné)
        $possibilities =  collect($estimations)
            ->map(fn($estimation) => new EstimationComputing($estimation, $budget))
            ->filter(fn($possibility) => $possibility->isValid($budget));

        $response = $this->_keepOptimalPossibility($possibilities)->toArray();
        $response['budget'] = $budget;
        return $response;
    }
}
