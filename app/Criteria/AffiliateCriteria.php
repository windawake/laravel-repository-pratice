<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AffiliateCriteria
 * @package namespace App\Criteria;
 */
class AffiliateCriteria implements CriteriaInterface
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
        ->leftJoin('affiliate', 'affiliate.id', '=', $table.'.affiliate_id');

        return $model;
    }
}
