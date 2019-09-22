<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 *
 * @package namespace App\Criteria;
 */
class AdminCriteria implements CriteriaInterface
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
        $fillable = $model->getModel()->getFillable();
        $field = in_array('admin_id', $fillable) ? 'admin_id' : 'manager_id';


        $model = $model
        ->leftJoin('admin', 'admin.id', '=', $table.'.'.$field);
        return $model;
    }
}
