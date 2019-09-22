<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class OrderReportMq{
    public static function repeatOrder($data){
        $redisKey = 'repeat.order.data.topic';

        $jsonData = json_encode($data);
        $redis = new \Redis();
        $host = config('database.redis.default.host');
        $port = config('database.redis.default.port');

        $redis->connect($host, $port);
        $ret = $redis->rPush($redisKey, $jsonData);
        $info = [
            'result' => $ret,
            'redis_key' => $redisKey,
            'data' => $data
        ];
        
        Log::info($info);
    }

}