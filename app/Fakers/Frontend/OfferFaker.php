<?php

namespace App\Fakers\Frontend;

class OfferFaker {
    public function getList(){
        $faker = \Faker\Factory::create();

        $list = [];
        for ($i = 0; $i < 20; $i++) {
            $info = [
                'offer_id' => $faker->unique()->randomNumber(),
                'offer_name' => $faker->name,
                'category_id' => $faker->randomElement([1,2,3,4,5,6]),
                'description' => $faker->sentence(),
                'default_payout' => $faker->randomFloat(2, 0, 30),
                'payout' => $faker->randomFloat(2, 0, 30),
                'epc' => $faker->randomFloat(2, 0, 1),
                'status' => $faker->randomElement([0,1]),
                'expired_time' => strtotime($faker->date()),
                'create_time' => strtotime($faker->date()),
                'update_time' => strtotime($faker->date()),
                'creator' => $faker->name,
                'modifier' => $faker->name,
            ];
            $list[] = $info;
        }
        
        $ret = [
            'pageSize' => 120,
            'current' => $faker->randomDigit,
            'total' => 100,
            'list' => $list
        ];

        return $ret;
    }

    public function getDetail(){
        $faker = \Faker\Factory::create();

        $ret = [
            'basic_info' => [
                'offer_id' => $faker->unique()->randomNumber(),
                'description' => $faker->sentence(),
                'offer_name' => $faker->name,
                'country_id' => $faker->randomNumber(),
                'category_id' => $faker->randomElement([1,2,3,4,5,6]),
                'payout' => $faker->randomFloat(2, 0, 30),
                'epc' => $faker->randomFloat(2, 0, 1),
                'status' => $faker->randomElement([0,1]),
                'expired_time' => strtotime($faker->date()),
                'creative' => [
                    [
                        'creative_type' => 1,
                        'creative_url' => $faker->imageUrl(),
                    ],
                    [
                        'creative_type' => 2,
                        'creative_url' => $faker->imageUrl(),
                    ],
                    [
                        'creative_type' => 3,
                        'creative_url' => 'hello.zip',
                    ]
                ]
            ],
            'offer_page' => [
                [
                    'offer_id' => $faker->unique()->randomNumber(),
                    'offer_name' => $faker->name,
                    'page_download_url' => $faker->url,
                    'tracking_url' => $faker->url,
                ],
                [
                    'offer_id' => $faker->unique()->randomNumber(),
                    'offer_name' => $faker->name,
                    'page_download_url' => $faker->url,
                    'tracking_url' => $faker->url,
                ],
                [
                    'offer_id' => $faker->unique()->randomNumber(),
                    'offer_name' => $faker->name,
                    'page_download_url' => $faker->url,
                    'tracking_url' => $faker->url,
                ],
            ],
            // 'sub_id' => [
            //     'sub_id_1' => $faker->unique()->randomNumber(),
            //     'sub_id_2' => $faker->unique()->randomNumber(),
            //     'sub_id_3' => $faker->unique()->randomNumber(),
            //     'sub_id_4' => $faker->unique()->randomNumber(),
            //     'sub_id_5' => $faker->unique()->randomNumber(),
            // ],
            'postback' => [
                [
                    'postback_id' => $faker->unique()->randomNumber(),
                    'goal_id' => $faker->numberBetween(1,2),
                    'postback_type' => $faker->numberBetween(1,2),
                    'url_code' => $faker->url,
                    'create_time' => strtotime($faker->date()),
                ],
                [
                    'postback_id' => $faker->unique()->randomNumber(),
                    'goal_id' => $faker->numberBetween(1,2),
                    'postback_type' => $faker->numberBetween(1,2),
                    'url_code' => $faker->url,
                    'create_time' => strtotime($faker->date()),
                ],
                [
                    'postback_id' => $faker->unique()->randomNumber(),
                    'goal_id' => $faker->numberBetween(1,2),
                    'postback_type' => $faker->numberBetween(1,2),
                    'url_code' => $faker->url,
                    'create_time' => strtotime($faker->date()),
                ],
            ]
            
        ];

        return $ret;
    }
}