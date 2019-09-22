<?php

namespace App\Fakers\Backend;

class BillingFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $timestamp = strtotime($faker->date());
            $info = [
                'billing_id' => $faker->unique()->randomNumber(),
                'period_time' => [$timestamp, $timestamp + 30000],
                'affiliate_id' => $faker->unique()->randomNumber(),
                'affiliate_name' => $faker->name,
                'billing_type' => $faker->numberBetween(1,3),
                'total_amount' => $faker->randomFloat(2, 0, 1000),
                'paid_time' => strtotime($faker->date()),
                'billing_status' => $faker->randomElement([0,1]),
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
        $billingType = request()->input('billing_type');
        $billingType = $billingType ?: $faker->numberBetween(1,3);
        $timestamp = strtotime($faker->date());
        $ret = [
            'billing_id' => $faker->unique()->randomNumber(),
            'affiliate_id' => $faker->unique()->randomNumber(),
            'affiliate_name' => $faker->name,
            'billing_type' => $billingType,
            'billing_status' => $faker->randomElement([0,1]),
            'total_amount' => $faker->randomFloat(2, 0, 5000),
            'period_time' => [$timestamp, $timestamp + 30000],
        ];

        $offerList = [];
        

        if($billingType == 1){
            for ($i = 0; $i < 6; $i++){
                $info = [
                    'offer_id' => $faker->unique()->randomNumber(),
                    'offer_name' => $faker->name,
                    'payout' => $faker->randomFloat(2, 0, 30),
                    'conversions' => $faker->numberBetween(0, 10),
                    'order_amount' => $faker->randomFloat(2, 0, 1000),
                ];
    
                $offerList[] = $info;
            }
            $ret['offer_list'] = $offerList;
        }else if($billingType == 2){
            for ($i = 0; $i < 6; $i++){
                $info = [
                    'offer_id' => $faker->unique()->randomNumber(),
                    'offer_name' => $faker->name,
                    'repeat_order_count' => $faker->unique()->randomNumber(),
                    'order_amount' => $faker->randomFloat(2, 0, 1000),
                ];
    
                $offerList[] = $info;
            }
            $ret['offer_list'] = $offerList;
        }

        return $ret;
    }
}