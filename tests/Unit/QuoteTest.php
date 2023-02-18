<?php

namespace Tests\Unit;
use App\Services\QuotesCalculation\Services\QuoteEstimationService;
use App\Services\QuotesCalculation\Services\QuoteEstimationServiceInterface;
use Tests\TestCase;


class QuoteTest extends TestCase
{
    private QuoteEstimationServiceInterface $_service;

    public function setUp(): void
    {
        parent::setUp();
        $this->_service = app(QuoteEstimationService::class);
    }

    public function test_budget_1000_dollars(): void
    {
        $budget = 1000;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 50,
            'association' => 10,
            'vendeur' => 16.47,
            'value' => 823.53,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_670_dollars(): void
    {
        $budget = 670;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 50,
            'association' => 5,
            'vendeur' => 10,
            'value' => 500,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_670_dollars_1_cents(): void {
        $budget = 670.01;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 50,
            'association' => 10,
            'vendeur' => 10,
            'value' => 500.01,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_110_dollars(): void {
        $budget = 110;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 10,
            'association' => 0,
            'vendeur' => 0,
            'value' => 0,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_111_dollars(): void {
        $budget = 111;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 10,
            'association' => 0,
            'vendeur' => 0.02,
            'value' => 0.98,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_116_dollars_2_cents(): void {
        $budget = 116.02;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 10,
            'association' => 5,
            'vendeur' => 0.02,
            'value' => 1,
            'budget' => $budget
        ];
        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }

    public function test_budget_1000000_dollars(): void {
        /**
         * Je sais que dans le document, le cas de test faisait état d'un montant de 19 304.51$ pour les frais du vendeur.
         * Cependant, en effectuant le calcul manuellement, 2% de 980 225.49$ égale bien 19 604.51$.
         * J'ai donc pris pour acquis qu'il s'agissait d'une erreur.
         */
        $budget = 1000000;
        $expected = [
            'entreposage' => 100,
            'utilisation' => 50,
            'association' => 20,
            'vendeur' => 19604.51,
            'value' => 980225.49,
            'budget' => $budget
        ];

        $results = $this->_service->estimate($budget);
        foreach ($results as $key => $result) {
            $this->assertEquals(number_format($expected[$key], 2), number_format($result, 2));
        }
    }
}
