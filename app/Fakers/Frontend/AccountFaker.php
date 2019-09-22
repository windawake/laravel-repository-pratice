<?php

namespace App\Fakers\Frontend;

class AccountFaker {
    public function getSettings(){
        $faker = \Faker\Factory::create();
        $ret = [
            'user_detail' => [
                'manager_email' => $faker->email,
                'email' => $faker->email,
                'first_name' => $faker->name,
                'last_name' => $faker->name
            ],
            'affiliate_detail' => [
                'affiliate_name' => $faker->name,
                'address1' => $faker->address,
                'address2' => $faker->address,
                'city' => $faker->city,
                'country_id' => $faker->randomNumber(),
                'phone' => $faker->phoneNumber,
                'status' => $faker->randomElement([-1,1]),
            ],
            'timezone_id' => 1,
        ];

        return $ret;
    }

    public function getBilling(){
        $faker = \Faker\Factory::create();
        $ret = [
            'billing_detail' => [
                'payment_method' => $faker->name,
                'beneficiary_name' => $faker->name,
                'bank_name' => $faker->name,
                'swift_number' => $faker->swiftBicNumber(),
                'account_number' => $faker->bankAccountNumber,
                'billing_frequency' => $faker->randomNumber(),
                'other_detail' => $faker->sentence(),
            ],
        ];

        return $ret;
    }
}