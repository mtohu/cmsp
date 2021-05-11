<?php
namespace app\api\controller;
use think\Controller;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/17
 * Time: 4:16 PM
 */
class Resident extends  Base
{
    /******绑定社区和房号呈现****/
    public function bindCommunityRoomPresent($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Resident', 'logic');
        $res = $login->bindCommunityRoomPresent($data);
        return $this->print_result($res);
    }
    /*****保持绑定社区和房号以及其他信息*****/
    public function saveBindCommunityRoom($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        $data['room_id'] =isset($input['room_id']) ? intval($input['room_id']) : 0;
        $data['resident_type'] =isset($input['resident_type']) ? intval($input['resident_type']) : 0;
        $data['identification'] =isset($input['identification']) ? trim($input['identification']) : "";
        $data['uphone'] =isset($input['uphone']) ? trim($input['uphone']) : "";
        $data['name'] =isset($input['name']) ? trim($input['name']) : "";
        $data['is_maintenance_staff'] =isset($input['is_maintenance_staff']) ? intval($input['is_maintenance_staff']) : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "请先登录";
            return $this->print_result($this->error_data);
        }
        if(!$data['room_id'] && $data['is_maintenance_staff'] ==0){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "请选择房号";
            return $this->print_result($this->error_data);
        }
        if(empty($data['resident_type']) && $data['is_maintenance_staff'] ==0){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "请选择用户类型";
            return $this->print_result($this->error_data);
        }
        if(empty($data['identification']) || !checkIdCard($data['identification'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "身份证号错误";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Resident', 'logic');
        $res = $login->saveBindCommunityRoom($data);
        return $this->print_result($res);
    }
    /******用户信息******/
    public function  residentInfo($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Resident', 'logic');
        $res = $login->residentInfo($data);
        return $this->print_result($res);
    }
    /******我下面成员******/
    public function residentMembers($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Resident', 'logic');
        $res = $login->residentMembers($data);
        return $this->print_result($res);
    }
    /*****审核用户成员*****/
    public function auditUserMembers($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;//当前操作用户id
        $data['room_id'] =isset($input['room_id']) ? intval($input['room_id']) : 0;//房号id
        $data['cover_resident_id'] =isset($input['cover_resident_id']) ? intval($input['cover_resident_id']) : 0;//被审核人
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        if(empty($data['room_id']) || empty($data['cover_resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "参数错误";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Resident', 'logic');
        $res = $login->auditUserMembers($data);
        return $this->print_result($res);
    }
    /******设置用户信息***/
    public function setResident($input){
        if(empty($input['token_resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $input['resident_id']=$input['token_resident_id'];
        $login = Controller('Resident', 'logic');
        $res = $login->setResident($input);
        return $this->print_result($res);
    }
}
