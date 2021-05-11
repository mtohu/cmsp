<?php
namespace app\api\logic;
use think\Db;
use think\Request;
use think\Exception;
use errors\ErrorException;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/18
 * Time: 2:41 PM
 */
class Repair extends Base{

    /*******添加维修页面呈现******/
    public function addRepairPresent($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $repair_types = Db::name("cmp_repair_type")->where('1=1')->select();
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = ['repair_type'=>$repair_types];
        return $this->error_data;
    }
    /*****保存维修信息*****/
    public function saveRepair($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $content = isset($input['content']) ? $input['content']:0;
        $repair_type_id = isset($input['repair_type_id']) ? $input['repair_type_id']:0;
        $img_arr = isset($input['img_arr']) ? $input['img_arr']:0;
        $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
        if(!isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->error_data;
        }
        try{
            $now_time=now_time();
            $saveData=array("create_date"=>date('Y-m-d H:i:s',$now_time));
            $saveData['content']=$content;
            $saveData['repair_type_id']=$repair_type_id;
            $saveData['resident_id']=$resident_id;
            Db::startTrans();
            $repair_id = Db::name("cmp_repair")->insertGetId($saveData);
            if(!$repair_id){
                throw new ErrorException("保存失败");
            }
            if(!empty($img_arr)){
                $imgs=array();
                foreach ($img_arr as $vv){
                    $imgs[]=['image_location'=>$vv,'repair_id'=>$repair_id,
                        'create_date'=>date('Y-m-d H:i:s',$now_time),'update_date'=>date('Y-m-d H:i:s',$now_time)];
                }
                $res=Db::name('cmp_image')->insertAll($imgs);
                if(!$res){
                    throw new ErrorException("保存图片地址失败");
                }
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
    /******维修列表******/
    public function repairList($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $page_index= isset($input['page_index'])?intval($input['page_index']):1;
        $page_index = $page_index<=0?1:$page_index;
        $page_size=isset($input['page_size'])?intval($input['page_size']):10;
        $page_start=$page_size * ($page_index-1);
        $resident = Db::name("cmp_resident")->where('id',$resident_id)->find();
        if(!isset($resident['id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->error_data;
        }
        $repairs = Db::name("cmp_repair")->alias('a')
                    ->field("a.id,a.content,a.status,a.create_date,a.update_date,a.result,a.repair_type_id,rt.type_name")
                    ->leftJoin("cmp_repair_type rt","rt.id=a.repair_type_id")
                    ->where([['a.resident_id','=',$resident_id]])
                    ->order("a.id desc")
                    ->limit($page_start,$page_size)->select();
        foreach ($repairs as $k => &$v){
            $images=Db::name("cmp_image")->where([['repair_id','=',$v['id']]])->select();
            $v['img_arr']=isset($images[0])?$images:[];
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $repairs;
        return $this->error_data;
    }
}
