<?php

namespace App\Fakers\Backend;

class DashboardFaker {

    public function summary_conversion(){
        $faker = \Faker\Factory::create();

        $ret = [
            'today' => $faker->randomFloat(2, 1000, 2000),
            'yesterday' => $faker->randomFloat(2, 1000, 9000),
            'last_7d' => $faker->randomFloat(2, 9000, 12000),
            'last_30d' => $faker->randomFloat(2, 30000, 40000),
            'this_year' => $faker->randomFloat(2, 300000, 400000),
        ];

        return $ret;
    }


    public function total_revenue(){
        $faker = \Faker\Factory::create();

        $ret = [
            [
                'timestamp' => strtotime('2019-06-01'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-02'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-03'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-04'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-05'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-06'),
                'cost' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-07'),
                'cost' => $faker->numberBetween(400, 800)
            ],
        ];

        return $ret;
    }

    public function performance(){
        $faker = \Faker\Factory::create();

        $ret = [
            [
                'timestamp' => strtotime('2019-06-01'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-02'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-03'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-04'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-05'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-06'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
            [
                'timestamp' => strtotime('2019-06-07'),
                'clicks' => $faker->numberBetween(900, 1500),
                'conversions' => $faker->numberBetween(400, 800)
            ],
        ];

        return $ret;
    }
    
}