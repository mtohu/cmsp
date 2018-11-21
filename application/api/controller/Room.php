<?php
namespace app\api\controller;
use think\Controller;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/17
 * Time: 4:16 PM
 */
class Room extends  Base
{
    /******查找该房号是否已经绑定业主****/
    public function checkRoomOwnerBind($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Room', 'logic');
        $res = $login->checkRoomOwnerBind($data);
        return $this->print_result($res);
    }
    /****获取所有的房号信息****/
    public function roomlist($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Room', 'logic');
        $res = $login->roomlist($data);
        return $this->print_result($res);
    }
    /*****获取自己设置的房号列表******/
    public function myRoomList($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Room', 'logic');
        $res = $login->myRoomList($data);
        return $this->print_result($res);
    }
    /*****删除关联房号******/
    public function delRelationRoom($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        $data['room_id'] = isset($input['room_id']) ? $input['room_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Room', 'logic');
        $res = $login->delRelationRoom($data);
        return $this->print_result($res);
    }
    /****添加关联房号*****/
    public function applyRelationRoom($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        $data['room_id'] = isset($input['room_id']) ? intval($input['room_id']) : 0;
        $data['resident_type'] = isset($input['resident_type']) ? intval($input['resident_type']):0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        if(empty($data['room_id']) || empty($data['resident_type'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "参数错误";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Room', 'logic');
        $res = $login->applyRelationRoom($data);
        return $this->print_result($res);

    }

}
