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
        $resident = Db::name("cmp_resident")
                    ->where([['room_id','=',$room_id],['resident_type','=',1],['is_verified','=',1]])->find();
        if(isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "该房号已经绑定业主";
            return $this->print_result($this->error_data);
        }

        $this->error_data['ErrorCode'] = 0;
        return $this->error_data;
    }
}
