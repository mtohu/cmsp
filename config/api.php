<?php
//接口配置文件
return [
    //c=控制器a=方法api_type=什么类型的接口need_auth=是否要验证 desc=描述
    'third_resident_login/post'     => ['c'=>'Login','a'=>'thirdByResidentLogin','api_type'=>'','need_auth'=>'false','desc'=>'third admin login'],
    'resident_login/post'     => ['c'=>'Login','a'=>'residentLogin','api_type'=>'','need_auth'=>'false','desc'=>'admin login'],
    'resident_logout/post'     => ['c'=>'Login','a'=>'residentLogout','api_type'=>'','need_auth'=>'false','desc'=>'admin logout'],
    'admin_user/post'     => ['c'=>'Admin','a'=>'adminUser','api_type'=>'','need_auth'=>'true','desc'=>'admin user'],
    'set_admin_user_pwd/post'     => ['c'=>'Admin','a'=>'setAdminUserPwd','api_type'=>'','need_auth'=>'true','desc'=>'set admin user pwd'],
    'admin_user_save/post'     => ['c'=>'Admin','a'=>'adminUserSave','api_type'=>'','need_auth'=>'true','desc'=>'商户信息保存'],

    'sms_send/post'        => ['c'=>'Publics','a'=>'smsSend','api_type'=>'','need_auth'=>'false','desc' =>'发送短信'],
    'get_province/post'    => ['c'=>'Publics','a'=>'getProvince','api_type'=>'','need_auth'=>'false','desc' =>'获取省份'],
    'get_city/post'        => ['c'=>'Publics','a'=>'getCity','api_type'=>'','need_auth'=>'false','desc' =>'获取市'],
    'get_area/post'        => ['c'=>'Publics','a'=>'getArea','api_type'=>'','need_auth'=>'false','desc' =>'获取地区'],
    'get_banner/post'      => ['c'=>'Index','a'=>'getBanner','api_type'=>'','need_auth'=>'false','desc' =>'获取轮播图'],
    'get_category/post'    => ['c'=>'Index','a'=>'getCategory','api_type'=>'','need_auth'=>'false','desc' =>'获取分类'],
    'get_category_more/post' => ['c'=>'Index','a'=>'getCategoryMore','api_type'=>'','need_auth'=>'false','desc' =>'获取分类'],
    'get_wxjsapi_sign/post'  => ['c'=>'Index','a'=>'getwxSignPackage','api_type'=>'','need_auth'=>'false','desc' =>'获取微信签名数据'],
    'goods_list/post'        => ['c'=>'Goods','a'=>'goodsList','api_type'=>'','need_auth'=>'false','desc' =>'获取小程序列表'],
    'goods_details/post'     => ['c'=>'Goods','a'=>'goodsDetails','api_type'=>'','need_auth'=>'false','desc' =>'获取小程序模版详情'],
    'pay_goods_details/post' => ['c'=>'Goods','a'=>'payGoodsDetails','api_type'=>'','need_auth'=>'true','desc' =>'支付小程序模版清单'],
    'orders_list/post'       => ['c'=>'Orders','a'=>'ordersList','api_type'=>'','need_auth'=>'true','desc' =>'获取小程序模版订单列表'],
    'pay_order/post'         => ['c'=>'Orders','a'=>'payOrder','api_type'=>'','need_auth'=>'true','desc' =>'支付订单'],
    'join_agent_detail/post'       => ['c'=>'Joinagent','a'=>'joinAgentDetail','api_type'=>'','need_auth'=>'true','desc' =>'加盟代理商详情'],
    'pay_join_agent_order/post'       => ['c'=>'Joinagent','a'=>'payJoinAgentOrder','api_type'=>'','need_auth'=>'true','desc' =>'生成代理商支付订单'],


];
