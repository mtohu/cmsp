<?php
namespace app\api\logic;
use Think\Db;
class Base{
    public $error_data=array('ErrorCode'=>1,'Type'=>'','ErrorMsg'=>'','ErrorSql'=>'','Data'=>array());
    public function __construct(){
        $this->error_data['ServerTime']=time();
    }
}
