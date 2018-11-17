<?php
namespace services;

use think\Db;
class BaseService{
   public  $error_data=array('ErrorCode'=>1,'ErrorMsg'=>'','ErrorSql'=>'','Data'=>array());
   public function __construct(){
   }
   //连接数据库
   public function DB($db_name) {
      return Db::connect($db_name);
   }
}
