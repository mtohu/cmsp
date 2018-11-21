<?php
namespace app\api\logic;
use think\Db;
use errors\ErrorException;
class Fee extends Base
{
    /****获取自己的缴费记录列表*****/
    public function myFeeList($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $search_name = isset($input['search_name']) ? trim($input['search_name']):"";
        $page_index= isset($input['page_index'])?intval($input['page_index']):1;
        $page_index = $page_index<=0?1:$page_index;
        $page_size=isset($input['page_size'])?intval($input['page_size']):10;
        $page_start=$page_size * ($page_index-1);
        $nowdate = date('Y-m-d H:i:s',now_time());
        $where =array();
        $where[]=['rr.resident_id','=',$resident_id];
        $where[]=['rr.is_verified','=',1];
        $where[]=['rr.resident_type','in',[1,2]];
        if(!empty($search_name)){
            $where[]=['fi.name','like',"%".$search_name."%"];
        }
        $field  ="f.fee_description,f.id,f.fee_amount,f.start_date,f.end_date,f.create_date,f.payment_status,
                   f.payment_date,f.fee_item_id,f.room_id,fi.name,fi.cycle";
        $field .= " ,(CASE 
                     WHEN (f.payment_status = 1) THEN
                     1
                     WHEN (f.end_date < '".$nowdate."') THEN
                     2
                     WHEN (f.payment_status = 0) THEN
                     4
                     ELSE
                     3
                     END
                     ) as sort_orders  ";
        $feeList = Db::name("cmp_fee")->alias('f')
                   ->field($field)
                   ->leftJoin("cmp_fee_item fi","f.fee_item_id = fi.id")
                   ->leftJoin("cmp_resident_room rr","rr.room_id = f.room_id ")
                   ->where($where)
                   ->order("sort_orders desc,id desc")
                   ->limit($page_start,$page_size)->select();
        foreach ($feeList as $key=> &$item){
            $fanzhu = Db::name("cmp_resident_room")->alias('crr')
                      ->field("a.*")
                      ->leftJoin("cmp_resident a","a.id = crr.resident_id")
                      ->where([['crr.is_verified','=',1],['crr.room_id','=',$item['room_id']],['crr.resident_type','=',1]])
                      ->find();
            $item['fanzhu']=[];
            if(isset($fanzhu['id'])){
                $item['fanzhu']=["name"=>$fanzhu['name'],"identification"=>substr_replace($fanzhu['identification'],'****',4,-4),
                                "uphone"=>$fanzhu['uphone']];
            }
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $feeList;
        return $this->error_data;
    }
}
