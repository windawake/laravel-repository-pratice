<?php

namespace App\Console\Commands;

use App\Fakers\MapFaker;
use App\Models\Offer;
use Illuminate\Console\Command;
use Log;

class OfferExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时脚本检查offer状态是否为过期expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $offerQuery = Offer::where('expired_time','<',time())
        ->where('status',[MapFaker::OFFER_STATUS_APPROVED, MapFaker::OFFER_STATUS_PENDING]);
        $count = $offerQuery->count();
        if($count){
            $ret = $offerQuery->update(['status' => MapFaker::OFFER_STATUS_EXPIRED]);
            if($ret){
                Log::notice("offer更新为过期的记录数为".$count);
            }
        }

        Log::notice("offer更新为过期的记录数为0");
    }
}
