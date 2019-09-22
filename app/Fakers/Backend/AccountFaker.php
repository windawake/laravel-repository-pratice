<?php

namespace App\Fakers\Backend;

class AccountFaker {
    public function getSettings(){
        $faker = Faker\Factory::create();
        $ret = [
            'user_detail' => [
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
                'phone' => $faker->tollFreePhoneNumber,
                'status' => $faker->randomElement([-1,1]),
            ],
            'timezone' => 1,
            'map' => [
                'affiliate_status' => [
                    1=>'正常',
                    -1=>'禁用'
                ],
            ],
        ];

        return $ret;
    }

    public function getBilling(){
        $faker = Faker\Factory::create();
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