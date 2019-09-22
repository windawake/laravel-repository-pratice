<?php

namespace App\Http\Controllers\Backend;

use App\Criteria\AffiliateCriteria;
use App\Fakers\MapFaker;
use App\Helpers\GenerateCode;
use App\Http\Requests\Backend\DomainUpdateRequest;
use App\Repositories\DomainRepository;
use App\Http\Controllers\Controller;
use App\Models\AffiliateDomain;
use App\Models\Domain;
use App\Transformers\DomainTransformer;

/**
 * Class DomainController.
 *
 * @package namespace App\Http\Controllers\Backend;
 */
class DomainController extends Controller
{
    /**
     * @var DomainRepository
     */
    protected $d;

    protected $validator;

    /**
     * DomainController constructor.
     *
     * @param DomainRepository $d
     */
    public function __construct(DomainRepository $d)
    {
        $this->d = $d;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->d->pushCriteria(AffiliateCriteria::class);
        $this->d->scopeQuery(function($query){
            $table = $query->getModel()->getTable();
            $query->addSelect(DomainTransformer::select());
            $query->where($table.'.source_type', MapFaker::DOMAIN_SOURCE_ADMIN);

            $query = DomainTransformer::where($query);
            $query = DomainTransformer::order($query);

            return $query;
        });

        $list = $this->d->paginate();
        return apiResponse($list);
    }

   // 创建+更新
    public function update(DomainUpdateRequest $request)
    {
        $id = request()->input('domain_id');
        $data = $request->all();
        $data['source_type'] = MapFaker::DOMAIN_SOURCE_ADMIN;
        $data['type'] = MapFaker::DOMAIN_TYPE_GLOBAL;
        DomainTransformer::rebuild($data);

        //有设置affiliate_id表示已使用
        if(!empty($data['affiliate_id'])){
            $data['used_flag'] = 1;
        }

        $ret = Domain::where(['domain_url' =>$data['domain_url']])->first();
        if($ret && $ret->id != $id){
            return apiResponse('The domain name is already in use',500);
        }

        if($id){
            Domain::find($id)->update($data);
            AffiliateDomain::where(['domain_id'=>$id])->first()->update($data);
        }else{
            $globalWhere = [
                'affiliate_id' => $data['affiliate_id'],
                'source_type' => MapFaker::DOMAIN_SOURCE_ADMIN,
                'type' => MapFaker::DOMAIN_TYPE_GLOBAL,
            ];
            $ret = Domain::where($globalWhere)->first();
            if($ret){
                return apiResponse('affiliate has added the global domain name',500);
            }
            $data['domain_code'] = GenerateCode::globalDomain();
            $domain = Domain::create($data);
            $data['domain_id'] = $domain->id;
            
            AffiliateDomain::create($data);
        }

        return apiResponse();
    }

}
