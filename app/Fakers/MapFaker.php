<?php

namespace App\Fakers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MapFaker {
    //region const
    const DOMAIN_TYPE_GLOBAL = 0;
    const DOMAIN_TYPE_SPECIFIC = 1;

    const DOMAIN_SOURCE_ADMIN = 0; // admin创建的domain
    const DOMAIN_SOURCE_AFF = 1; // affiliate创建的domain

    const AFF_SOURCE_USER = 1;
    const AFF_SOURCE_SYSTEM = 2;

    const AFF_STATUS_PENDING = 0;
    const AFF_STATUS_APPROVED = 1;
    const AFF_STATUS_REJECTED = -1;

    const ADMIN_STATUS_PENDING = 0;
    const ADMIN_STATUS_APPROVED = 1;
    const ADMIN_STATUS_REJECTED = -1;

    const OFFER_STATUS_PENDING = 0;
    const OFFER_STATUS_APPROVED = 1;
    const OFFER_STATUS_EXPIRED = -1;

    const DEFAULT_TIMEZONE_ID = 74;

    const BILLING_TYPE_REVENUE = 1;
    const BILLING_TYPE_REPEAT = 2;
    const BILLING_TYPE_BONUS = 3;

    const BONUS_TYPE_BONUS = 1;
    const BONUS_TYPE_REPEAT = 2;

    const ORDER_STATUS_PAID = 1;

    const ROLE_ACCOUNT_MANAGER = 1;

    const STATUS_APPROVED = 1;
    const STATUS_PAID = 1;
    const STATUS_PENDING = 0;
    const STATUS_CANCELLED = 0;

    const POSTBACK_GOAL_LEAD = 1;
    const POSTBACK_GOAL_CONFIRMED = 2;

    //endregion

    public static function getBillingBonusMap(){
        $map = [
            self::BILLING_TYPE_BONUS => self::BONUS_TYPE_BONUS,
            self::BILLING_TYPE_REPEAT => self::BONUS_TYPE_REPEAT,
        ];

        return $map;
    }

    public function getFrontendCountry(){
        $countryList = DB::table('country')->get(['id','en_name']);

        return $countryList;
    }
    public function getBackendCountry(){
        $countryList = DB::table('country')->get(['id','en_name']);
        return $countryList;
    }

    public function getFrontendRegion(){
        $regionList = DB::table('region')->get(['id','country_id','en_name']);

        return $regionList;
    }
    public function getBackendRegion(){
        $regionList = DB::table('region')->get(['id','country_id','en_name']);
        return $regionList;
    }

    public function getFrontendMap(){

        $timezoneList = DB::table('timezone')->get();
        
        $roleList = DB::table('role')->get()->toArray();

        $ret = [
            'offer_category_id'=>[
                1 => 'Casino & Crypto',
                2 => 'Diet',
                3 => 'Sweepstakes',
                4 => 'ED/Muscle',
                5 => 'Skin',
                6 => 'Other',
            ],
            'offer_status'=>[ 
                1 =>'approved',
                0 =>'pending',
                -1 => 'expired',
            ],
            'creative_type' => [
                1 => 'zip',
                2 => 'image',
                3 => 'video',
            ],
            'creative_status' => [
                1 => 'active',
                0 => 'pending',
            ],
            'order_status'=>[ 
                1 =>'confirmed',
                0 =>'pending',
                -1 => 'cancelled',
                -2 => 'fraud',
            ],
            'domain_type' => [
                1 => 'Specific',
                0 => 'Global',
            ],
            'domain_status' => [
                1 => 'active',
                0 => 'pending'
            ],
            'billing_type' => [
                1 => 'revenue',
                2 => 'repeat order bonus',
                3 => 'bonus',
            ],
            'billing_status' => [
                1 => 'paid',
                0 => 'pending',
                -1 => 'cancelled',
            ],
            'bonus_type' => [
                1 => 'Bonus',
                2 => 'Repeat Order',
            ],
            'bonus_status' => [
                1 => 'paid',
                0 => 'pending',
                -1 => 'cancelled',
            ],
            'postback_type' => [
                2 =>'iFrame Code',
                1 =>'Postback URL',
                0 =>'global_flag',
            ],
            'postback_status' => [
                1 =>'active',
                0 =>'pending',
            ],
            'postback_goal' => [
                1 =>'Lead',
                2 =>'Confirmed',
            ],
            'global_flag' => [
                1 => '是',
                0 => '否',
            ],
            'timezone' => $timezoneList,
            'role' => array_column($roleList, 'en_name', 'id')
        ];

        return $ret;
    }


    public function getBackendMap(){

        $timezoneList = DB::table('timezone')->get();
        
        $roleList = DB::table('role')->get()->toArray();

        $ret = [
            'offer_category_id'=>[
                1 => 'Casino & Crypto',
                2 => 'Diet',
                3 => 'Sweepstakes',
                4 => 'ED/Muscle',
                5 => 'Skin',
                6 => 'Other',
            ],
            'offer_status'=>[ 
                1 =>'approved',
                0 =>'pending',
                -1 => 'expired',
            ],
            'order_status'=>[ 
                1 =>'confirmed',
                0 =>'pending',
                -1 => 'cancelled',
                -2 => 'fraud',
            ],
            'domain_type' => [
                1 => 'Specific',
                0 => 'Global',
            ],
            'domain_status' => [
                1 => 'active',
                0 => 'pending'
            ],
            'billing_type' => [
                1 => 'revenue',
                2 => 'repeat order bonus',
                3 => 'bonus',
            ],
            'billing_status' => [
                1 =>'paid',
                0 =>'pending',
                -1 => 'cancelled',
            ],
            'bonus_type' => [
                1 => 'Bonus',
                2 => 'Repeat Order',
            ],
            'bonus_status' => [
                1 => 'paid',
                0 => 'pending',
                -1 => 'cancelled',
            ],
            'postback_type' => [
                2 =>'iFrame Code',
                1 =>'Postback URL',
                0 =>'global_flag',
            ],
            'postback_status' => [
                1 =>'active',
                0 =>'pending',
            ],
            'goal_id' => [
                1 =>'Lead',
                2 =>'Confirmed',
            ],
            'global_flag' => [
                1 => '是',
                0 => '否',
            ],
            'affiliate_source' => [
                1 => 'User',
                2 => 'System',
            ],
            'affiliate_status' => [
                1 =>'Approved',
                0 =>'Pending',
                -1 =>'Rejected',
            ],
            'admin_status' => [
                1 =>'Approved',
                0 =>'Pending',
                -1 =>'Rejected',
            ],
            'creative_type' => [
                1 => 'zip',
                2 => 'image',
                3 => 'video',
            ],
            'creative_status' => [
                1 => 'active',
                0 => 'pending',
            ],
            'billing_frequency' => [
                1 => 'weekly',
                2 => 'monthly',
            ],
            'timezone' => $timezoneList,
            'role' => array_column($roleList, 'en_name', 'id')
        ];

        return $ret;
    }

    public static function csvTransformer($data= []){
        $dict = [
            'category_id'=>[
                1 => 'Casino & Crypto',
                2 => 'Diet',
                3 => 'Sweepstakes',
                4 => 'ED/Muscle',
                5 => 'Skin',
                6 => 'Other',
            ],
            'offer_status'=>[ 
                1 =>'approved',
                0 =>'pending',
                -1 => 'expired',
            ],
            'order_status'=>[ 
                1 =>'confirmed',
                0 =>'pending',
                -1 => 'cancelled',
                -2 => 'fraud',
            ],
            'domain_type' => [
                1 => 'Specific',
                0 => 'Global',
            ],
            'domain_status' => [
                1 => 'active',
                0 => 'pending'
            ],
            'billing_type' => [
                1 => 'revenue',
                2 => 'repeat order bonus',
                3 => 'bonus',
            ],
            'billing_status' => [
                1 =>'paid',
                0 =>'pending',
                -1 => 'cancelled',
            ],
            'bonus_type' => [
                1 => 'Bonus',
                2 => 'Repeat Order',
            ],
            'bonus_status' => [
                1 => 'paid',
                0 => 'pending',
                -1 => 'cancelled',
            ],
            'postback_type' => [
                2 =>'iFrame Code',
                1 =>'Postback URL',
                0 =>'global_flag',
            ],
            'postback_status' => [
                1 =>'active',
                0 =>'pending',
            ],
            'postback_goal' => [
                1 =>'Lead',
                2 =>'Confirmed',
            ],
            'global_flag' => [
                1 => '是',
                0 => '否',
            ],
            'affiliate_source' => [
                1 => 'User',
                2 => 'System',
            ],
            'affiliate_status' => [
                1 =>'Approved',
                0 =>'Pending',
                -1 =>'Rejected',
            ],
            'admin_status' => [
                1 =>'Approved',
                0 =>'Pending',
                -1 =>'Rejected',
            ],
            'creative_type' => [
                1 => 'zip',
                2 => 'image',
                3 => 'video',
            ],
            'creative_status' => [
                1 => 'active',
                0 => 'pending',
            ],
            'billing_frequency' => [
                1 => 'weekly',
                2 => 'monthly',
            ]
        ];

        $keyArr = array_keys($dict);

        foreach($data as $key => $value){
            if(in_array($key, $keyArr)){
                $data[$key] = Arr::get($dict, $key.'.'.$value, $value);
            }
        }

        return $data;
    }


}