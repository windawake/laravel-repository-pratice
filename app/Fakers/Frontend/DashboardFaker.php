<?php

namespace App\Fakers\Frontend;

class DashboardFaker {

    public function summary_revenue(){
        $faker = \Faker\Factory::create();

        $ret = [
            'revenue' => [
                'today' => $faker->randomFloat(2, 1000, 2000),
                'yesterday' => $faker->randomFloat(2, 1000, 9000),
                'last_7d' => $faker->randomFloat(2, 9000, 12000),
                'last_30d' => $faker->randomFloat(2, 30000, 40000),
                'this_year' => $faker->randomFloat(2, 300000, 400000),
            ],
            'conversion_rate' => $faker->numerify("##.##%"),
            'bonus' => [
                'this_month' => $faker->randomFloat(2, 30000, 40000),
                'last_month' => $faker->randomFloat(2, 30000, 40000),
                'this_year' => $faker->randomFloat(2, 300000, 400000),
            ]
            
        ];

        return $ret;
    }

    public function my_offers(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 5; $i++) {
            $info = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'payout' => $faker->randomFloat(2, 0, 30),
                'clicks' => $faker->numberBetween(100, 2000),
                'orders' => $faker->numberBetween(50, 200),
                'conversions' => $faker->numberBetween(20, 60),
                'revenue' =>  $faker->randomFloat(2, 500, 3000),
                'epc' => $faker->randomFloat(4, 0, 10),
                'repeat_orders' => $faker->numberBetween(0, 10),
                'repeat_orders_bonus' => $faker->randomFloat(2, 200, 1000),
            ];
            $list[] = $info;
        }
        
        $ret = [
            'pageSize' => 5,
            'current' => $faker->randomDigit,
            'total' => 100,
            'list' => $list
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

    public function payout(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 5; $i++) {
            $timestamp = strtotime($faker->date());
            $info = [
                'billing_id' => $faker->unique()->randomNumber(),
                'create_time' => strtotime($faker->date()),
                'period_time' => [$timestamp, $timestamp + 30000],
                'total_amount' => $faker->randomFloat(2, 600, 2000),
                'payment_method' => $faker->creditCardType,
                'status' => $faker->randomElement([1,0]),
            ];

            $list[] = $info;
        }
        
        $ret = $list;

        return $ret;
    }

    
}