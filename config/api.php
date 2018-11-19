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
    'resident_members/post'     => ['c'=>'Resident','a'=>'residentMembers','api_type'=>'','need_auth'=>'true','desc'=>'获取用户下面成员'],
    'audit_user_members/post'     => ['c'=>'Resident','a'=>'auditUserMembers','api_type'=>'','need_auth'=>'true','desc'=>'审核成员'],
    'set_resident/post'     => ['c'=>'Resident','a'=>'setResident','api_type'=>'','need_auth'=>'true','desc'=>'设置更新用户信息'],


    'room_list/post'     => ['c'=>'Room','a'=>'roomlist','api_type'=>'','need_auth'=>'true','desc'=>'获取所有房号信息'],
    'my_room_list/post'     => ['c'=>'Room','a'=>'myRoomList','api_type'=>'','need_auth'=>'true','desc'=>'获取自己关联的房号'],
    'del_relation_room/post'     => ['c'=>'Room','a'=>'delRelationRoom','api_type'=>'','need_auth'=>'true','desc'=>'解除关联房号'],
    'apply_relation_room/post'     => ['c'=>'Room','a'=>'applyRelationRoom','api_type'=>'','need_auth'=>'true','desc'=>'申请关联房号'],

    'sms_send/post'         => ['c'=>'Publics','a'=>'smsSend','api_type'=>'','need_auth'=>'false','desc' =>'发送短信'],
    'check_verify_code/post'=> ['c'=>'Publics','a'=>'checkVerifyCode','api_type'=>'','need_auth'=>'false','desc' =>'检查手机号验证码'],
    'banner_list/post'    => ['c'=>'Index','a'=>'bannerList','api_type'=>'','need_auth'=>'false','desc' =>'获取banner轮播'],
    'notice_list/post'     => ['c'=>'Index','a'=>'noticeList','api_type'=>'','need_auth'=>'false','desc' =>'获取通知列表'],


    'add_repair_present/post'        => ['c'=>'Repair','a'=>'addRepairPresent','api_type'=>'','need_auth'=>'true','desc' =>'添加维修页面显示数据'],
    'save_repair/post'      => ['c'=>'Repair','a'=>'saveRepair','api_type'=>'','need_auth'=>'true','desc' =>'保存维修信息'],
    'repair_list/post'    => ['c'=>'Repair','a'=>'repairList','api_type'=>'','need_auth'=>'false','desc' =>'获取维修信息列表'],

    'my_fee_list/post' => ['c'=>'Fee','a'=>'myFeeList','api_type'=>'','need_auth'=>'true','desc' =>'获取自己缴费记录'],
    'pay_order/post'         => ['c'=>'Fee','a'=>'payOrder','api_type'=>'','need_auth'=>'true','desc' =>'生成支付订单'],

    'get_wxjsapi_sign/post'  => ['c'=>'Index','a'=>'getwxSignPackage','api_type'=>'','need_auth'=>'false','desc' =>'获取微信签名数据'],





];
