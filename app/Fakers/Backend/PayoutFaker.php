<?php

namespace App\Fakers\Backend;

class PayoutFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $timestamp = strtotime($faker->date());
            $info = [
                'billing_id' => $faker->unique()->randomNumber(),
                'billing_code' => $faker->bankAccountNumber,
                'type' => $faker->randomElement([1,2,3]),
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'create_time' => strtotime($faker->date()),
                'period_time' => [$timestamp, $timestamp + 30000],
                'total_amount' => $faker->randomFloat(2, 600, 2000),
                'payment_method' => $faker->creditCardType,
                'status' => $faker->randomElement([1,0]),
            ];

            $list[] = $info;
        }
        
        $ret = [
            'pageSize' => 20,
            'current' => $faker->randomDigit,
            'total' => 100,
            'list' => $list
        ];

        return $ret;
    }

    public function getDetail(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 5; $i++) {
            $info = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'payout' => $faker->randomFloat(2, 0, 30),
                'conversions' => $faker->numberBetween(20, 60),
                'revenue' =>  $faker->randomFloat(2, 500, 3000),
                'bonus' =>  $faker->optional(0.5, null)->randomFloat(2, 0, 1000),
                'repeat_orders_bonus' => $faker->optional(0.5, null)->randomFloat(2, 0, 1000),
            ];

            $info['amount'] = $info['revenue'] + $info['bonus'] + $info['repeat_orders_bonus'];

            $list[] = $info;
        }

        $totalAmount = array_sum(array_column($list,'amount'));
        
        $ret = [
            'total_amount' => $totalAmount,
            'list' => $list
        ];

        return $ret;
    }
    
}