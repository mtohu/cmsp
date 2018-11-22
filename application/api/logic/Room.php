<?php
namespace app\api\logic;
use think\Db;
use app\api\logic\Tokens;
use think\Request;
use think\Exception;
use think\facade\Cookie;
use think\facade\Session;
use errors\ErrorException;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/17
 * Time: 4:38 PM
 */
class Room extends Base
{
    /******查找该房号是否已经绑定业主****/
    public function checkRoomOwnerBind($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $room_id = isset($input['room_id']) ? $input['room_id']:0;
        $resident_room = Db::name("cmp_resident_room")
                    ->where([['room_id','=',$room_id],['resident_type','=',1],['is_verified','=',1]])->find();
        if(isset($resident_room['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "该房号已经绑定业主";
            return $this->error_data;
        }

        $this->error_data['ErrorCode'] = 0;
        return $this->error_data;
    }
    /****获取所有的房号信息****/
    public function roomlist($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $rooms=Db::name("cmp_room")
                  ->where([['room_state','=',1]])
                  ->order("order_sort desc,id desc")
                  ->select();
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = ['rooms'=>$rooms,'resident_types'=>resident_type()];
        return $this->error_data;
    }
    /*****获取自己设置的房号列表******/
    public function myRoomList($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $resident_rooms = Db::name("cmp_resident_room")->alias('rr')
            ->field("rr.id as resident_room_id,rr.room_id,rr.resident_type,rr.is_verified,r.region,r.building,r.unit,r.room_no,r.lat,r.lng,r.coord_type,rr.update_date")
            ->leftJoin("cmp_room r","r.id = rr.room_id")
            ->where([['rr.resident_id','=',$resident_id],['rr.is_verified','in',[0,1]],['r.room_state','=',1]])
            ->order("rr.id desc")
            ->limit(100)
            ->select();
        foreach ($resident_rooms as $kk=>&$vv){
            $vv['resident_type_name']=resident_type($vv['resident_type']);
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $resident_rooms;
        return $this->error_data;
    }
    /*****删除关联房号******/
    public function delRelationRoom($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $room_id = isset($input['room_id']) ? intval($input['room_id']):0;
        $del=Db::name("cmp_resident_room")->where([['room_id','=',$room_id],['resident_id','=',$resident_id]])->delete();
        $this->error_data['ErrorCode'] = 1;
        $this->error_data['ErrorMsg'] = "解除失败";
        if($del){
            $this->error_data['ErrorMsg'] = "解除成功";
            $this->error_data['ErrorCode'] = 0;
        }
        return $this->error_data;
    }
    /****申请关联房号*****/
    public function applyRelationRoom($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $room_id = isset($input['room_id']) ? intval($input['room_id']):0;
        $resident_type = isset($input['resident_type']) ? intval($input['resident_type']):0;
        try{
            Db::startTrans();
            $room=Db::name("cmp_room")->where('id',$room_id)->find();
            if(!isset($room['id'])){
                throw new ErrorException("房号不存在");
            }
            $resident_room= Db::name("cmp_resident_room")->where([['room_id','=',$room_id],['resident_id','=',$resident_id]])->find();
            if(isset($resident_room['id']) && $resident_room['resident_type'] == $resident_type){
                throw new ErrorException("已经申请关联该房号请不要重复申请");
            }

            $saveData=array("resident_id"=>$resident_id,"room_id"=>$room_id,"resident_type"=>$resident_type,
                      'update_date'=>date('Y-m-d H:i:s',now_time()));
            if(!isset($resident_room['id'])){
                $res=Db::name("cmp_resident_room")->insert($saveData);
            }else{
                $saveData['is_verified']=0;
                $res=Db::name("cmp_resident_room")->where('id',$resident_room['id'])->data($saveData)->update();
            }
            if(!$res){
                throw new ErrorException("申请失败");
            }
            Db::commit();
        }catch (ErrorException $e){
            Db::rollback();
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        return $this->error_data;
    }
}
