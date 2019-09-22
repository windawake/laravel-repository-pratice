<?php

namespace App\Repositories;

use App\Fakers\MapFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 *
 * @package namespace App\Repositories;
 */
class BaseEntryRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return static::class;
    }

    public function getTable()
    {
        return $this->model->getTable();
    }


    public function select($columns = ['*'])
    {
        $columns = is_array($columns) ? $columns : func_get_args();
        $this->model = $this->model->select($columns);

        return $this;
    }

    // 当前用户全局
    public function scopeAffiliate()
    {
        $table = $this->model->getTable();
        $this->model = $this->model->where($table.'.affiliate_id', Auth()->id());

        return $this;
    }

    public function chunkList(){
        $limit = 2000;
        $list = $this->paginate($limit);
        $list = json_decode(json_encode($list),true);

        $ret = [];
        foreach(Arr::get($list, 'data') as $item){
            $ret[] = MapFaker::csvTransformer($item);
        }

        //获取下一页
        $nextPage = request()->input('page', 1) + 1;
        request()->merge(['page' => $nextPage]);

        return $ret;
    }

    public function chunkRebuildList(){
        $limit = 2000;
        $list = $this->newPaginateWithOrder($limit);
        $list = json_decode(json_encode($list),true);

        $ret = [];
        foreach(Arr::get($list, 'data') as $item){
            $ret[] = MapFaker::csvTransformer($item);
        }

        //获取下一页
        $nextPage = request()->input('page', 1) + 1;
        request()->merge(['page' => $nextPage]);

        return $ret;
    }


    public function newPaginateWithOrder($limit = null)
    {
        $this->applyCriteria();
        $this->applyScope();
        $tableSql = $this->model->toRawSql();
        $orderField = request()->input('order_by.field');
        $direction = request()->input('order_by.order');

        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $rawTable = DB::getTablePrefix().$this->model->getModel()->getTable();

        $query = DB::table(DB::raw('('.$tableSql.') as '.$rawTable));
        if($orderField && in_array($direction, ['asc','desc'])){
            $query->orderBy($orderField, $direction);
        }
        $results = $query->paginate($limit)->toArray();
        $this->resetModel();

        return $this->parserResult($results);
    }
    
}
