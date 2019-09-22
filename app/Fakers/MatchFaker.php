<?php

namespace App\Fakers;

use App\Models\Admin;
use App\Models\Affiliate;
use App\Models\Domain;
use App\Models\Offer;
use App\Models\OfferPage;
use Auth;

class MatchFaker {
    public function getFrontendSearch(){
        $request = request();
        $field = $request->input('field');
        $value = $request->input('value');
        $ret = [];

        // 模糊查询offer
        if($field == 'offer_name'){
            $offer = Offer::select(['id as offer_id','offer_code','name as offer_name']);
            if($value){
                $offer->where('name','like', '%'.$value.'%');
                $offer->orWhere('offer_code', $value);
            }
            $ret = $offer->limit(20)->orderBy('id','desc')->get();
        }

        // 模糊查询offer_page
        if($field == 'offer_page_name'){
            $offerPage = OfferPage::select(['id as offer_page_id','offer_id','page_code','name as offer_page_name']);
            if($value){
                $offerPage->where('name','like', '%'.$value.'%');
                $offerPage->orWhere('page_code', $value);
            }
            $ret = $offerPage->limit(20)->orderBy('id','desc')->get();
        }

        // 模糊查询domain
        if($field == 'domain_url'){
            $domain = Domain::select(['id as domain_id','domain_code','domain_url']);
            $domain->where('affiliate_id', Auth()->id());
            if($value){
                $domain->where('domain_url','like', '%'.$value.'%');
                $domain->orWhere('domain_code', $value);
            }
            $ret = $domain->limit(20)->get();          
        }

        return $ret;
    }

    public function getBackendSearch(){
        $request = request();
        $field = $request->input('field');
        $value = $request->input('value');
        $status = $request->input('status');
        
        $ret = [];

        // 模糊查询offer
        if($field == 'offer_name'){
            $offer = Offer::select(['id as offer_id','offer_code','name as offer_name']);
            if($value){
                $offer->where('name','like', '%'.$value.'%');
                $offer->orWhere('offer_code', $value);
            }
            $ret = $offer->limit(20)->orderBy('id','desc')->get();
        }

        // 模糊查询offer_page
        if($field == 'offer_page_name'){
            $offerPage = OfferPage::select(['id as offer_page_id','offer_id','page_code','name as offer_page_name']);
            if($value){
                $offerPage->where('name','like', '%'.$value.'%');
                $offerPage->orWhere('page_code', $value);
            }
            $ret = $offerPage->limit(20)->orderBy('id','desc')->get();
        }

        // 模糊查询affiliate
        if($field == 'affiliate_name'){
            $affiliate = Affiliate::select(['id as affiliate_id','affiliate_code','affiliate_name','email as affiliate_email']);
            if($value){
                $affiliate->where('affiliate_name','like', '%'.$value.'%');
                $affiliate->orWhere('affiliate_code', $value);
            }
            if(!is_null($status)){
                $affiliate->where('status', intval($status));
            }
            $ret = $affiliate->get();
        }

        if($field == 'affiliate_code'){
            $affiliate = Affiliate::where('affiliate_code',$value)
            ->select(['id as affiliate_id','affiliate_code','affiliate_name','email as affiliate_email']);
            if(!is_null($status)){
                $affiliate->where('status', intval($status));
            }
            $ret = $affiliate->get();
        }

        // 模糊查询domain
        if($field == 'domain_url'){
            $domain = Domain::select(['id as domain_id','domain_code','domain_url']);
            if($value){
                $domain->where('domain_url','like', '%'.$value.'%');
                $domain->orWhere('domain_code', $value);
            }
            $ret = $domain->limit(20)->get();          
        }

        if($field == 'admin_email'){
            $ret = Admin::where('email','like','%'.$value.'%')
            ->select(['id as admin_id','email as admin_email'])
            ->get();
        }

        if($field == 'manager_email'){
            $admin = Admin::leftJoin('admin_role', 'admin_role.admin_id', '=', 'admin.id')
            ->where('admin_role.role_id', MapFaker::ROLE_ACCOUNT_MANAGER);
            if($value){
                $admin->where('admin.email','like','%'.$value.'%');
            }

            $ret = $admin->select(['admin.id as manager_id','admin.email as manager_email','admin.status as admin_status'])
            ->get();
        }

        return $ret;
    }


}