<?php

namespace App\Criteria;

use App\Models\ClicksDetail;
use App\Models\Order;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * 
 * @package namespace App\Criteria;
 */
class OrderCriteria implements CriteriaInterface
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
        $joinTable = Order::affSharding()->getModel()->getTable();

        $model = $model
        ->leftJoin($joinTable, $joinTable.'.click_id', '=', $table.'.id');

        return $model;
    }
}
