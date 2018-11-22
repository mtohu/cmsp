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
            $saveData=array("identification"=>$identification,"uphone"=>$uphone);
            $saveData["name"]=$name;
            $saveData["is_maintenance_staff"]=$is_maintenance_staff;
            $saveData["update_date"]=date('Y-m-d H:i:s',now_time());
            $res = Db::name("cmp_resident")->where('id',$resident_id)->data($saveData)->update();
            if(!$res){
                throw new ErrorException("保存失败");
            }
            $resident_room_data=array("resident_id"=>$resident_id,"room_id"=>$room_id,'resident_type'=>$resident_type
                           ,"update_date"=>date('Y-m-d H:i:s',now_time()));
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
    /******用户信息*******/
    public function residentInfo($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id'] : 0;
        $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
        if(!isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "用户不存在";
            return $this->error_data;
        }
        $resident['resident_name']=$resident['name'];
        $resident['account_name']=$resident['account'];
        $resident['resident_id']=$resident_id;
//        if(!empty($resident['face_img'])){
//            if(strpos(strtolower($resident['face_img']),"http") === false){
//                $resident['face_img']=get_newpic_url($resident['face_img']);
//            }
//        }
        $resident['identification_view']="";
        if(!empty($resident['identification'])){
            $resident['identification_view']=substr_replace($resident['identification'],'****',4,-4);
        }
        $resident['is_fangzhu']=0;
        $resident_rooms=Db::name("cmp_resident_room")->where([['resident_id','=',$resident_id],['resident_type','=',1]
            ,['is_verified','=',1]])->select();
        if(count($resident_rooms) > 0){
            $resident['is_fangzhu']=1;
        }
        unset($resident['password']);
        unset($resident['atoken']);
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $resident;
        return $this->error_data;
    }
    /******我下面成员******/
    public function residentMembers($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id'] : 0;
        $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
        if(!isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "用户不存在";
            return $this->error_data;
        }
        $resident_rooms=Db::name("cmp_resident_room")->where([['resident_id','=',$resident_id],['resident_type','=',1]
                      ,['is_verified','=',1]])->select();
        if(!isset($resident_rooms[0])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "不是房主";
            return $this->error_data;
        }
        $room_ids=array();
        foreach ($resident_rooms as $k=>$v){
            $room_ids[]=$v['room_id'];
        }
        $residents = Db::name("cmp_resident_room")
            ->alias('rr')
            ->field("rr.room_id,rr.resident_id,rr.resident_type,r.name,r.uphone,r.phone,rr.is_verified,rr.update_date")
            ->leftJoin("cmp_resident r","r.id = rr.resident_id")
            ->where([['rr.room_id','in',$room_ids],['rr.resident_type','in',[2,3]]])
            ->order("rr.id desc")
            ->limit(1000)
            ->select();
        foreach ($residents as $kk => &$vv){
            $vv['resident_type_name']=resident_type($vv['resident_type']);//房屋类型
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $residents;
        return $this->error_data;
    }
    /******审核某个成员用户*****/
    public function auditUserMembers($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id'] : 0;
        $cover_resident_id =isset($input['cover_resident_id']) ? intval($input['cover_resident_id']) : 0;
        $room_id =isset($input['room_id']) ? intval($input['room_id']) : 0;
        $coverresident = Db::name("cmp_resident")->where('id',$cover_resident_id)->find();
        if(!isset($coverresident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "被审核的用户不存在";
            return $this->error_data;
        }
        try{
            Db::startTrans();
            $res =Db::name("cmp_resident_room")
                     ->where([['room_id','=',$room_id],['resident_id','=',$cover_resident_id]])
                     ->data(['is_verified'=>1,'update_date'=>date('Y-m-d H:i:s',now_time())])->update();
            if(!$res){
                throw new ErrorException("审核失败");
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
    /******设置用户信息***/
    public function setResident($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id'] : 0;
        $uphone = isset($input['uphone'])?trim($input['uphone']):"";
        $phone = isset($input['phone'])?trim($input['phone']):"";
        $verify_code   = isset($input['verify_code'])?$input['verify_code']:"";
        $name = isset($input['name'])?trim($input['name']):"";
        $face_img = isset($input['face_img'])?trim($input['face_img']):"";
        $identification = isset($input['identification'])?trim($input['identification']) : "";
        $is_maintenance_staff = isset($input['is_maintenance_staff'])?intval($input['is_maintenance_staff']) :-1;
        try{
            Db::startTrans();
            $saveData=array('update_date'=>date('Y-m-d H:i:s',now_time()));
            if(!empty($uphone)){
                $saveData['uphone']=$uphone;
            }
            if(!empty($identification)){
                $saveData['identification']=$identification;
            }
            if(!empty($name)){
                $saveData['name']=$name;
            }
            if(!empty($face_img)){
                $saveData['face_img']=$face_img;
            }
            if(!empty($is_maintenance_staff) && $is_maintenance_staff != -1){
                $saveData['is_maintenance_staff']=$is_maintenance_staff;
            }
            if(!empty($phone)){
                $resident=Db::name("cmp_resident")->where([['phone','=',$phone]])->find();
                if(isset($resident['id'])){
                    throw new ErrorException("手机号已经存在");
                }
                //验证码
                $verify_code_arr = Db::name('cmp_verify')->where([['phone','=', $phone],['type','=',1]])->order('id','desc')->find();
                if(!isset($verify_code_arr['id'])){
                    throw new ErrorException("验证码错误");
                }
                if(isset($verify_code_arr['verify']) && ($verify_code_arr['period'] < now_time() || $verify_code_arr['is_use'] ==1)){
                    throw new ErrorException("验证码过期或验证码已被使用");
                }
                if(isset($verify_code_arr['verify']) && $verify_code != $verify_code_arr['verify']){
                    throw new ErrorException("验证码不正确");
                }
                $res=Db::name('cmp_verify')->where([['id','=',$verify_code_arr['id']]])->update(['is_use'=>1]);
                if(!$res){
                    throw new ErrorException("更新验证码状态错误");
                }
                $saveData['phone']=$phone;
            }
            $res =Db::name("cmp_resident")
                ->where([['id','=',$resident_id]])
                ->data($saveData)->update();
            if(!$res){
                throw new ErrorException("更新失败");
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
