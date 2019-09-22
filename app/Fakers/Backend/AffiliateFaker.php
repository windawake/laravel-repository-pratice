<?php

namespace App\Fakers\Backend;

class AffiliateFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'affiliate_id' => $faker->unique()->randomNumber(),
                'affiliate_name' => $faker->name,
                'manager_id' => $faker->unique()->randomNumber(),
                'account_manager' => $faker->name,
                'affiliate_type' => $faker->randomElement([1,2]),
                'status' => $faker->randomElement([0,1]),
                'clicks' => $faker->numberBetween(100, 2000),
                'orders' => $faker->numberBetween(50, 200),
                'conversions' => $faker->numberBetween(20, 60),
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

    public function getDetail(){
        $faker = \Faker\Factory::create();
        $domainList = [];
        $offerList = [];

        for ($i = 0; $i < 6; $i++){
            $domainList[] = [
                'domain_id' => $faker->unique()->randomNumber(),
                'domain_url' => $faker->domainName,
            ];

            $offerList[] = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'default_payout' => $faker->randomFloat(2, 0, 30),
                'payout' => $faker->randomFloat(2, 0, 30),
            ];
        }

        $ret = [
            'affiliate_detail' => [
                'affiliate_id' => $faker->unique()->randomNumber(),
                'affiliate_name' => $faker->name,
                'address1' => $faker->address,
                'address2' => $faker->address,
                'city' => $faker->city,
                'country_id' => $faker->unique()->randomNumber(),
                'phone' => $faker->tollFreePhoneNumber,
            ],
            'user_defail' => [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->companyEmail,
                'password' => $faker->name,
                'confirm_password' => $faker->name,
                'phone' => $faker->imei,
                'status' => $faker->numberBetween(0,1),
                'manager_id' => $faker->unique()->randomNumber(),
            ],
            'billing_defail' => [
                'address1' => $faker->address,
                'address2' => $faker->address,
                'city' => $faker->city,
                'country_id' => $faker->unique()->randomNumber(),
                'region_id' => $faker->unique()->randomNumber(),
                'zip_code' => $faker->postcode,
                'payment_method' => $faker->creditCardType,
                'beneficiary_name' => $faker->bankAccountNumber,
                'bank_name' => $faker->bankAccountNumber,
                'swift_number' => $faker->swiftBicNumber,
                'account_number' => $faker->bankAccountNumber,
                'billing_frequency' => $faker->unique()->randomNumber(),
                'other_detail' => $faker->sentence(),
            ],
            'offer_settings' => [
                'domain_list' => $domainList,
                'offer_list' => $offerList,
            ],
            
        ];

        return $ret;
    }

    public function getPayoutOffers()
    {
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'default_payout' => $faker->randomFloat(2, 0, 30),
                'payout' => $faker->optional(0.2, null)->randomFloat(2, 0, 30),
                'effective_time' => strtotime($faker->date()),
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