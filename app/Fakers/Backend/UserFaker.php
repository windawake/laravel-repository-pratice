<?php

namespace App\Fakers\Backend;

class UserFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'admin_id' => $faker->unique()->randomNumber(),
                'email' => $faker->companyEmail,
                'phone' => $faker->imei,
                'admin_status' => $faker->numberBetween(0,1),
                'manager_id' => $faker->unique()->randomNumber(),
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

    public function getDetail(){
        $faker = \Faker\Factory::create();

        $ret = [
            'admin_id' => $faker->unique()->randomNumber(),
            'email' => $faker->companyEmail,
            'phone' => $faker->imei,
            'admin_status' => $faker->numberBetween(0,1),
            'role_id' => $faker->unique()->randomNumber(),
        ];

        return $ret;
    }
}