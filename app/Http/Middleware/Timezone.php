<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Timezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $timezoneId = $request->input('timezone_id');
        if(intval($timezoneId)){
            $en_name = DB::table("timezone")->where('id', $timezoneId)->value('en_name');
            $en_name = $en_name ?: 'PRC';
            date_default_timezone_set($en_name);
        }

        $response = $next($request);

        return $response;
    }
}
