<?php
namespace services;
use think\Db;
class GeneratService extends BaseService{
   public function __construct(){
   }
   /**生成编号**/
   public function generat_add($save){
       if(!is_array($save)) return False;
       try{
           Db::startTrans();
           $db = Db::name("cmp_generat_no");
           $res = $db->insertGetId($save);
           Db::commit();
       }catch (Exception $e) {
           Db::rollback();
           return False;
       }
       return $res;
   }
}
