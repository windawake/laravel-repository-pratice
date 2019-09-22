<?php

namespace App\Listeners;

use App\Models\ActionLog;
use App\Models\Affiliate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\json_encode;

class ModelDeletedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        //记录登录后用户的操作行为
        if(Auth::check()){
            $model = $event->model;
            $authTable = Auth()->user()->getTable();
            $attributes = $model->getAttributes();
            $attributes = Arr::except($attributes, ['created_time', 'updated_time', 'creator', 'modifier']);

            $inData = [
                'user_type' => $authTable == 'admin' ? 2 : 1,
                'user_id' => Auth()->id(),
                'model_table' => $model->getTable(),
                'model_id' => $model->getKey(),
                'title' => "delete",
                'content' => json_encode($attributes),
                'uri' => request()->getRequestUri(),
                'created_ip' => request()->getClientIp(),
            ];
            
            ActionLog::create($inData);
        }
    }
}
