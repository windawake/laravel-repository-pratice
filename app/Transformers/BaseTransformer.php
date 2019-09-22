<?php

namespace App\Transformers;

use Illuminate\Support\Arr;
use League\Fractal\TransformerAbstract;

/**
 * @method static BaseTransformer setTable(string $table)
 * @method static array sqlColumn($columns)
 * @method static array select()
 * @method static BaseTransformer where($query)
 * @method static BaseTransformer order($query)
 * @method static array rebuild()
 * 
 */
class BaseTransformer extends TransformerAbstract
{
    protected $table = '';
    //转为table识别字段
    protected $transform = [];

    //查询字段
    protected $selectColumn = [];

    //排序字段
    protected $orderColumns = [];

    //where语句转换规则
    protected $whereRules = [];

    static $instance = [];

    public static function getInstance(){
        $class = static::class;
        if(!isset(self::$instance[$class])){
            self::$instance[$class] = new static();
        }

        return self::$instance[$class];
    }

    public function call_setTable($table)
    {
        $this->table = $table;
        
        return $this;
    }

    /**
     * 格式化sql select字段
     */
    public function call_sqlColumn($columns = []){
        if(!$columns) $columns = $this->selectColumn;

        foreach($columns as $key => $field){
            if(is_string($field)){
                $column = array_get($this->transform, $field, $field);
                if(!strpos($column, '.')){
                    $column = trim($this->table).'.'.trim($column);
                }
            }else{
                $column = $field;
            }

            $columns[$key] = $column;
        }

    
        return $columns;
    }
    
    /**
     * 查询语句
     */
    public function call_select()
    {
        $columns = $this->call_sqlColumn($this->selectColumn);
        $this->orderColumns = \sqlHumanRead($columns);
        return $columns;
    }

    /**
     * where语句
     */
    public function call_where($query)
    {
        foreach($this->whereRules as $rule){
            $data = explode('|', $rule);
            $condition = $data[0];
            $field = $data[1];
            $column = array_get($this->transform, $field, $field);
            if(!strpos($column, '.')){
                $column = trim($this->table).'.'.trim($column);
            }
            $value = request()->input($field);
    
            if($value !== null){
                if($condition == '='){
                    $query->where($column, $value);
                }elseif($condition == 'in'){
                    $query->whereIn($column, $value);
                }else if($condition == 'like'){
                    $query->where($column, 'like', '%'.$value.'%');
                }else if($condition == 'between'){
                    $type = Arr::get($data, 2, 'second');
                    if($type == 'millisecond'){
                        foreach($value as $k => $val){
                            $value[$k] = $val*1000;
                        }
                    }
                    $query->whereBetween($column, $value);
                }else if($condition == 'map'){
                    $key = $data[2];
                    $val = $data[3];
                    $map = $value;

                    $column = $column.$map[$key];
                    $value = $map[$val];
                    
                    $query->where($column, $value);
                }else{
                    $query->where($column, $condition, $value);
                }
            }
            
        }
    
        return $query;
    }

    /**
     * order by语句
     */
    public function call_order($query)
    {
        $orderField = request()->input('order_by.field');
        $orderColumns = $this->orderColumns ?: $this->selectColumn;
        
        if($orderField){
            $column = array_get($this->transform, $orderField, $orderField);
            if(!strpos($column, '.')){
                $column = trim($this->table).'.'.trim($column);
            }
            $direction = request()->input('order_by.order');
            if($orderField && in_array($direction, ['asc', 'desc'])){
                $query->orderBy($column, $direction);
            }
        }

        return $query;
    }

    /**
     * insert或者update语句
     */
    public static function rebuild(&$data){
        if(!is_array($data)) return [];
        
        $instance = new static;
        $ret = [];
        $data = Arr::dot($data);

        foreach($data as $key => $value){
            $field = array_get($instance->transform, $key);
            if($field){
                $key = last(explode('.', $field));
            }
            $ret[$key] = $value;
        }
        $data = $ret;
        return $ret;
    }

    public static function __callStatic($method, $parameters)
    {
        $method = 'call_'.$method;
        if(method_exists(static::class, $method)){
            return static::getInstance()->$method(...$parameters);
        }
    }

    public function __call($method, $parameters)
    {
        $method = 'call_'.$method;
        if(method_exists(static::class, $method)){
            return $this->$method(...$parameters);
        }
    }
}
