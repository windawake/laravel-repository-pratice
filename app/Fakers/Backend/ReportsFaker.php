<?php

namespace App\Fakers\Backend;

class ReportsFaker {
    public function getSummary(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'offer_page_name' => $faker->name,
                'goal_id' => $faker->randomElement([1,2]),
                'category_id' => $faker->randomElement([1,2,3,4,5,6]),
                'country_id' => $faker->numberBetween(0,100),
                'sub_id_1' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_2' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_3' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_4' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_5' => $faker->optional(0.5, null)->numberBetween(1,6),
                'clicks' => $faker->numberBetween(100, 2000),
                'orders' => $faker->numberBetween(50, 200),
                'conversions' => $faker->numberBetween(20, 60),
                'payout' => $faker->randomFloat(2, 0, 30),
                'revenue' =>  $faker->randomFloat(2, 500, 3000),
                'repeat_orders' => $faker->numberBetween(0, 10),
                'repeat_orders_bonus' => $faker->randomFloat(2, 200, 1000),
            ];

            $info['order_click_rate'] = sprintf("%.2f", $info['orders']/$info['clicks']);
            $info['conversion_order_rate'] = sprintf("%.2f", $info['conversions']/$info['orders']);
            $info['conversion_click_rate'] = sprintf("%.2f", $info['conversions']/$info['clicks']);
            $info['total_revenue'] = $info['revenue'] + $info['repeat_orders_bonus'];

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

    public function getOrderList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'id' => $faker->unique()->randomNumber(),
                'order_time' => strtotime($faker->date()),
                'order_no' => $faker->lexify('NO######'),
                'offer_name' => $faker->name,
                'offer_page_name' => $faker->name,
                'order_status' => $faker->randomElement([1,0]),
                'country_id' => $faker->numberBetween(0,100),
                'payout' => $faker->randomFloat(2, 0, 30),
                'revenue' =>  $faker->randomFloat(2, 500, 3000),
                'sub_id_1' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_2' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_3' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_4' => $faker->optional(0.5, null)->numberBetween(1,6),
                'sub_id_5' => $faker->optional(0.5, null)->numberBetween(1,6),
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

    public function getBonusList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'create_time' => strtotime($faker->date()),
                'bonus_id' => $faker->unique()->randomNumber(),
                'bonus_code' => $faker->bankAccountNumber,
                'type' => $faker->randomElement([1,2,3,4,5,6]),
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->randomFloat(2, 0, 30),
                'country_id' => $faker->numberBetween(0,100),
                'bonus_status' => $faker->randomElement([1,0]),
                'amount' => $faker->randomFloat(2, 0, 30),
                'repeat_order_count' => $faker->numberBetween(0,10),
                'memo' => $faker->sentence()
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

    
}