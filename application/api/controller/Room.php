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
            return $this->error_data;
        }
        $login = Controller('Room', 'logic');
        $res = $login->checkRoomOwnerBind($data);
        return $this->print_result($res);
    }

}
