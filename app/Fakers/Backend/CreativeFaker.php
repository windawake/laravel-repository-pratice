<?php

namespace App\Fakers\Backend;

class CreativeFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'creative_id' => $faker->unique()->randomNumber(),
                'creative_name' => $faker->name.'.'.$faker->randomElement(['gif','jpg','zip']),
                'creative_type' => $faker->numberBetween(1,3),
                'offer_name' => $faker->name,
                'creative_size' => $faker->numberBetween(10000, 100000),
                'create_time' => strtotime($faker->date()),
                'creative_status' => $faker->randomElement([0,1]),
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

        $ret = [
            'creative_id' => $faker->unique()->randomNumber(),
            'creative_name' => $faker->image(),
            'creative_type' => $faker->numberBetween(1,3),
            'offer_name' => $faker->name,
            'creative_size' => $faker->numberBetween(10000, 100000),
            'create_time' => strtotime($faker->date()),
            'creative_status' => $faker->randomElement([0,1]),
        ];

        return $ret;
    }
}