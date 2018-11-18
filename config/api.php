<?php
//接口配置文件
return [
    //c=控制器a=方法api_type=什么类型的接口need_auth=是否要验证 desc=描述
    'third_resident_login/post'     => ['c'=>'Login','a'=>'thirdByResidentLogin','api_type'=>'','need_auth'=>'false','desc'=>'third  login'],
    'resident_login/post'     => ['c'=>'Login','a'=>'residentLogin','api_type'=>'','need_auth'=>'false','desc'=>' login'],
    'register_resient/post'     => ['c'=>'Login','a'=>'registerResient','api_type'=>'','need_auth'=>'false','desc'=>'注册用户并登录成功'],
    'resident_logout/post'     => ['c'=>'Login','a'=>'residentLogout','api_type'=>'','need_auth'=>'false','desc'=>' logout'],
    'check_account_isexit/post'     => ['c'=>'Login','a'=>'checkAccountIsexit','api_type'=>'','need_auth'=>'false','desc'=>'检查帐号信息是否存在'],
    'find_pwd/post'     => ['c'=>'Login','a'=>'findPwd','api_type'=>'','need_auth'=>'false','desc'=>' 找回密码'],
    'check_room_owner_bind/post'     => ['c'=>'Room','a'=>'checkRoomOwnerBind','api_type'=>'','need_auth'=>'true','desc'=>'检查房号是否已经绑定了业主'],
    'bind_community_room_present/post'     => ['c'=>'Resident','a'=>'bindCommunityRoomPresent','api_type'=>'','need_auth'=>'true','desc'=>'绑定社区和房号页面数据'],
    'save_bind_community_room/post'     => ['c'=>'Resident','a'=>'saveBindCommunityRoom','api_type'=>'','need_auth'=>'true','desc'=>'保存绑定信息'],
    'resident_info/post'     => ['c'=>'Resident','a'=>'residentInfo','api_type'=>'','need_auth'=>'true','desc'=>'获取用户信息'],
    'sms_send/post'         => ['c'=>'Publics','a'=>'smsSend','api_type'=>'','need_auth'=>'false','desc' =>'发送短信'],
    'check_verify_code/post'=> ['c'=>'Publics','a'=>'checkVerifyCode','api_type'=>'','need_auth'=>'false','desc' =>'检查手机号验证码'],
    'banner_list/post'    => ['c'=>'Index','a'=>'bannerList','api_type'=>'','need_auth'=>'false','desc' =>'获取banner轮播'],
    'notice_list/post'     => ['c'=>'Index','a'=>'noticeList','api_type'=>'','need_auth'=>'false','desc' =>'获取通知列表'],


    'add_repair_present/post'        => ['c'=>'Repair','a'=>'addRepairPresent','api_type'=>'','need_auth'=>'true','desc' =>'添加维修页面显示数据'],
    'save_repair/post'      => ['c'=>'Repair','a'=>'saveRepair','api_type'=>'','need_auth'=>'true','desc' =>'保存维修信息'],
    'repair_list/post'    => ['c'=>'Repair','a'=>'repairList','api_type'=>'','need_auth'=>'false','desc' =>'获取维修信息列表'],

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
