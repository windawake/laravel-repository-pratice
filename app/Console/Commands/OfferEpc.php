<?php

namespace App\Console\Commands;

use App\Models\Offer;
use App\Models\SummaryReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfferEpc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:epc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '最近七天的该offer的revenue/clicks*100%，保留四位小数';

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
        $strtime = strtotime(date("Y-m-d"));
        $last7day = $strtime - (7*24*3600);
        $startTime = $last7day.'000';

        $list = SummaryReport::where('create_time', '>', $startTime)->select([
            DB::raw('sum(revenue) as revenue'),
            DB::raw('sum(click_count) as click_count'),
            'offer_id',
        ])->groupBy('offer_id')->get();

        foreach($list as $item){
            $epc = $item->click_count ? sprintf("%.4f", $item->revenue/$item->click_count) : 0;
            $offer = Offer::find($item->offer_id);
            
            if(!$offer){
                Log::notice("找不到offer_id: ".$item->offer_id);continue;
            }
            $offer->update(['epc' => $epc]);
            $item->epc = $epc;

            Log::notice("offer更新epr: ".json_encode($item));
        }

    }
}
