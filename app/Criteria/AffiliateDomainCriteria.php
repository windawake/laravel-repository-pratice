<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * @package namespace App\Criteria;
 */
class AffiliateDomainCriteria implements CriteriaInterface
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
        ->leftJoin('affiliate_domain', 'affiliate_domain.offer_id', '=', $table.'.offer_id');

        return $model;
    }
}
