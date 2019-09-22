<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ManagerCriteria @todo manager就是admin
 *
 * @package namespace App\Criteria;
 */
class ManagerCriteria implements CriteriaInterface
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
        $model = $model
        ->leftJoin('admin', 'admin.id', '=', 'affiliate.manager_id');

        return $model;
    }
}
