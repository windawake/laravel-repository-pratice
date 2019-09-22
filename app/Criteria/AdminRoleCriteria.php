<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdminRoleCriteria.
 *
 * @package namespace App\Criteria;
 */
class AdminRoleCriteria implements CriteriaInterface
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
        ->leftJoin('admin_role', 'admin_role.admin_id', '=', 'admin.id')
        ->leftJoin('role', 'role.id', '=', 'admin_role.role_id');
        return $model;
    }
}
