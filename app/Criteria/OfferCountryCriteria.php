<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * 
 * @package namespace App\Criteria;
 */
class OfferCountryCriteria implements CriteriaInterface
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
            $joinField = 'offer.id';
        }else{
            $joinField = $table.'.offer_id';
        }

        $model = $model
        ->leftJoin('offer_country', 'offer_country.offer_id', '=', $joinField);

        return $model;
    }
}
