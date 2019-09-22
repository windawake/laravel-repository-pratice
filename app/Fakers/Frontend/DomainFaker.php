<?php

namespace App\Fakers\Frontend;

class DomainFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'domain_id' => $faker->unique()->randomNumber(),
                'domain_url' => $faker->domainName,
                'domain_type' => $faker->randomElement([1,2]),
                'offer_name' => $faker->name,
                'status' => $faker->randomElement([1,2]),
                'create_time' => strtotime($faker->date()),
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