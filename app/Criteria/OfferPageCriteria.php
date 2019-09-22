<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * 
 * @package namespace App\Criteria;
 */
class OfferPageCriteria implements CriteriaInterface
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

        $model = $model
        ->leftJoin('offer_page', 'offer_page.id', '=', $table.'.offer_page_id');

        return $model;
    }
}
