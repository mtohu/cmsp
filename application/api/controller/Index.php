<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Index extends Base
{
    /*****滚动图******/
    public  function bannerList($input){
        $banners = Db::name("cmp_banner")->where([['banner_state','=',1]])->order("order_sort desc,id desc")->select();
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $banners;
        return $this->print_result($this->error_data);

    }
    /*****通知信息*****/
    public function noticeList($input){
        $datetime = date('Y-m-d H:i:s',now_time());
        $notices = Db::name("cmp_notice")->alias('a')
            ->leftJoin('cmp_notice_type nt','a.notice_type_id = nt.id')
            ->field("a.id,a.title,a.content,a.notice_type_id,nt.type_name")
            ->whereTime('a.effective_date', '<=', $datetime)
            ->whereTime('a.expire_date', '>=', $datetime)
            ->order("id desc")
            ->select();
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $notices;
        return $this->print_result($this->error_data);
    }

}
