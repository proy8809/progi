<?php
return [
    'entreposage' => [
        'amount' => 100
    ],
    'utilisation' => [
        'min' => 10,
        'max' => 50,
        'prct' => 10
    ],
    'association' => [
        'forks' => [
            [
                'amount' => 5,
                'gte' => 1,
                'lte' => 500
            ],
            [
                'amount' => 10,
                'gt' => 500,
                'lte' => 1000
            ],
            [
                'amount' => 15,
                'gt' => 1000,
                'lte' => 3000
            ],
            [
                'amount' => 20,
                'gt' => 3000,
                'lte' => PHP_INT_MAX
            ]
        ]
    ],
    'vendeur' => [
        'prct' => 2
    ],
];
