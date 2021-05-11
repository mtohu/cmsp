<?php
namespace app\api\controller;
use think\Controller;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/18
 * Time: 2:32 PM
 */
class Repair extends  Base
{
    /*******添加维修页面呈现******/
    public function addRepairPresent($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Repair', 'logic');
        $res = $login->addRepairPresent($data);
        return $this->print_result($res);
    }
    /*****保存维修信息*****/
    public function saveRepair($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        $data['repair_type_id'] = isset($input['repair_type_id'])?intval($input['repair_type_id']):0;
        $data['content'] = isset($input['content'])?trim($input['content']):"";
        $data['img_arr'] = isset($input['img_arr'])?json_decode($input['img_arr'], true):[];
        if(empty($data['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        if(empty($data['repair_type_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "请选择维修类型";
            return $this->print_result($this->error_data);
        }
        if(empty($data['content'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "请填写维修内容";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Repair', 'logic');
        $res = $login->saveRepair($data);
        return $this->print_result($res);

    }
    /******维修列表******/
    public function repairList($input){
        $input['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($input['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Repair', 'logic');
        $res = $login->repairList($input);
        return $this->print_result($res);
    }
}
