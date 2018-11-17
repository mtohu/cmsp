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
class Resident extends Base
{
    /******绑定社区和房号呈现****/
    public function bindCommunityRoomPresent($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
        if(!isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->error_data;
        }
        $communitys = Db::name("cmp_community")->where("1=1")->select();
        $rooms = Db::name("cmp_room")->where([['room_state','=',1]])->order("order_sort desc,room_no asc")->select();
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = ["communitys"=>$communitys,"rooms"=>$rooms,"resident_type_arr"=>resident_type(),
                                 "resident"=>$resident];
        return $this->error_data;
    }
    /******保持绑定社区和房号以及其他信息*******/
    public function saveBindCommunityRoom($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id'] : 0;
        $room_id =isset($input['room_id']) ? intval($input['room_id']) : 0;
        $resident_type =isset($input['resident_type']) ? intval($input['resident_type']) : 0;
        $identification =isset($input['identification']) ? trim($input['identification']) : "";
        $uphone =isset($input['uphone']) ? trim($input['uphone']) : "";
        $name =isset($input['name']) ? trim($input['name']) : "";
        $is_maintenance_staff = isset($inpu['is_maintenance_staff'])?$input['is_maintenance_staff']:0;
        try{
            Db::startTrans();
            $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
            if(!isset($resident['id'])){
                throw new ErrorException("用户不存在");
            }
            $rroom = Db::name("cmp_resident_room")->where([['resident_id','=',$resident_id],['room_id','=',$room_id]])->find();
            if(isset($rroom['id']) && intval($rroom['is_verified']) == 1){
                throw new ErrorException("已经绑定请不要重复绑定");
            }
            $saveData=array("resident_type"=>$resident_type,"identification"=>$identification,"uphone"=>$uphone);
            //$saveData["room_id"]=$room_id;
            $saveData["is_maintenance_staff"]=$is_maintenance_staff;
            $saveData["update_date"]=date('Y-m-d H:i:s',now_time());
            $res = Db::name("cmp_resident")->where('id',$resident_id)->data($saveData)->update();
            if(!$res){
                throw new ErrorException("保存失败");
            }
            $resident_room_data=array("resident_id"=>$resident_id,"room_id"=>$room_id,"update_date"=>date('Y-m-d H:i:s',now_time()));
            $res=Db::name("cmp_resident_room")->insert($resident_room_data);
            if(!$res){
                throw new ErrorException("保存失败");
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
