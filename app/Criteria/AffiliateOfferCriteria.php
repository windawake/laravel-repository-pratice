<?php

namespace App\Criteria;

use App\Models\AffiliateOffer;
use Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * @package namespace App\Criteria;
 */
class AffiliateOfferCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $table = $model->getModel()->getTable();

        if($table == 'offer'){
            $joinField = $table.'.id';
        }else{
            $joinField = $table.'.offer_id';
        }
        $affiliateId = request()->input('affiliate_id') ?: Auth()->id();

        $affOffer = AffiliateOffer::where(['affiliate_id' => $affiliateId]);

        $model = $model
        ->leftJoinSub($affOffer, 'affiliate_offer', function($join) use($joinField){
            $join->on('affiliate_offer.offer_id','=',$joinField);
        });

        return $model;
    }
}
