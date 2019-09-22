<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class GenerateCode{
    static $affiliate_key = 'generate:affiliate_code';
    static $offer_key = 'generate:offer_code';
    static $offerPage_key = 'generate:offer_page_code';
    static $domainGlobal_key = 'generate:global_domain_code';
    static $domainSpecific_key = 'generate:specific_domain_code';
    static $bonus_key = 'generate:bonus_code';
    static $billing_key = 'generate:billing_code';


    public static function affiliate(){
        $year = date('y');
        $number = Redis::connection()->incr(self::$affiliate_key.':'.$year);
        $code = 'A'.$year.str_pad($number, 4, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function offer($categoryId = 1){
        $number = Redis::incr(self::$offer_key);
        $code = 'O'.$categoryId.str_pad($number, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function offerPage($categoryId = 1){
        $number = Redis::incr(self::$offerPage_key);
        $code = 'OP'.$categoryId.str_pad($number, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function globalDomain(){
        $number = Redis::incr(self::$domainGlobal_key);
        $code = 'G'.str_pad($number, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function specificDomain(){
        $number = Redis::incr(self::$domainSpecific_key);
        $code = 'S'.str_pad($number, 5, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function bonus(){
        $date = date('ymd');
        $key = self::$bonus_key.':'.$date;
        
        $number = Redis::incr($key);
        if(!Redis::ttl($key)){
            Redis::expire($key,3600*24*2);
        }
        
        $code = 'BO'.$date.str_pad($number, 4, '0', STR_PAD_LEFT);

        return $code;
    }

    public static function billing(){
        $date = date('ymd');
        $key = self::$billing_key.':'.$date;

        $number = Redis::incr($key);
        if(!Redis::ttl($key)){
            Redis::expire($key,3600*24*2);
        }

        $code = 'B'.$date.str_pad($number, 4, '0', STR_PAD_LEFT);

        return $code;
    }
}