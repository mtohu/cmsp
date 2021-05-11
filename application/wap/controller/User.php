<?php
namespace app\wap\controller;

use app\wap\logic\Img;
use app\wap\logic\Room;
use think\Controller;
use think\facade\Session;

class User extends Base
{
    /**
     * 用户首页
     */
    public function index()
    {
        $nav_item = [
            'index' => '',
            'manager' => '',
            'user' => 'nav-item-active'
        ];
        $this->assign('nav_item', $nav_item);
        //用户信息
        $request_api = new RequestApi();
        $request_api->api_action = 'resident_info';
        $return_data = $request_api->request_ajax()->getData();
        $user_info = [
            'name' => $this->ResidentAccount['ResidentName'],
            'identification' => '',
            'uphone' => '',
            'phone' => '111',
            'face_img' => ''
        ];
        if(isset($return_data['ErrorCode']) && $return_data['ErrorCode'] == 0){
            $user_info = $return_data['Data'];
        }
        if($user_info['face_img'] == ''){
            $user_info['face_img'] = '/static/img/face-img.jpg';
        }

        $this->assign('user_info', $user_info);
        return $this->fetch();
    }

    /**
     * 修改头像
     */
    public function changeFaceImg()
    {
        $base64_txt = input('base64_txt');
        if(empty($base64_txt)){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = '上传的图片错误';
            return $this->print_result($this->error_data);
        }
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_txt, $result)){
            $type = $result[2];
            if(!in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                //文件类型错误
                $this->error_data['ErrorCode'] = 1;
                $this->error_data['ErrorMsg'] = '上传的图片类型错误';
                return $this->print_result($this->error_data);
            }
        }else{
            //文件错误
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = '上传的图片错误';
            return $this->print_result($this->error_data);
        }
        $img_cls = new Img(150, 150);
        $img_url = $img_cls->createNewImg($base64_txt);
        if(!empty($img_url)){
            //获取数据
            $request_api = new RequestApi();
            $request_api->api_action = 'set_resident';
            $request_api->params['face_img'] = $img_url;
            $return_data = $request_api->request_ajax()->getData();
            if(isset($return_data['ErrorCode']) && $return_data['ErrorCode'] != 0){
                $this->error_data['ErrorCode'] = 1;
                $this->error_data['ErrorMsg'] = '修改失败';
                return $this->print_result($this->error_data);
            }

            $this->error_data['ErrorCode'] = 0;
            $this->error_data['Data']['face_img'] = $img_url;
            return $this->print_result($this->error_data);
        }
        $this->error_data['ErrorCode'] = 1;
        $this->error_data['ErrorMsg'] = '修改失败';
        return $this->print_result($this->error_data);
    }

    /**
     * 我的家庭成员/租客
     */
    public function myFamily()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/index')
            ],
            'title' => '家庭成员/租客',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //获取数据
        $request_api = new RequestApi();
        $request_api->api_action = 'resident_members';
        $return_data = $request_api->request_ajax()->getData();
        $members_list = [];
        if(isset($return_data['ErrorCode']) && $return_data['ErrorCode'] == 0){
            $members_list = $return_data['Data'];
        }

        $this->assign('members_list', $members_list);
        return $this->fetch();
    }

    /**
     * 评价
     */
    public function assess()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/index')
            ],
            'title' => '评价我们',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 关于我们
     */
    public function aboutUs()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/index')
            ],
            'title' => '关于我们',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 设置页面
     */
    public function userSet()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/index')
            ],
            'title' => '设置',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 房间列表
     */
    public function roomList()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/userSet')
            ],
            'title' => '房号设置',
            'right_btn' => [
                'is_show' => true,
                'btn_name' => '添加',
                'url' => url('User/applyUserRoom')
            ]
        ];
        $this->assign('head', $head);
        //房间列表
        $request_api = new RequestApi();
        $request_api->api_action = 'my_room_list';
        $return_res = $request_api->request_ajax()->getData();
        $room_list = [];
        if($return_res['ErrorCode'] == 0){
            $room_list = $return_res['Data'];
        }

        $this->assign('room_list', $room_list);
        return $this->fetch();
    }

    /**
     * 申请房间
     */
    public function applyUserRoom()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('User/roomList')
            ],
            'title' => '申请绑定房间',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //获取房间数据
        $regions = \app\wap\logic\Room::getRegions();
        $buildings = $buildings = \app\wap\logic\Room::getBuildings($regions[0]);
        $units = \app\wap\logic\Room::getUnits($regions[0], $buildings[0]);
        $rooms = \app\wap\logic\Room::getRooms($regions[0], $buildings[0], $units[0]);

        $this->assign('regions', $regions);
        $this->assign('buildings', $buildings);
        $this->assign('units', $units);
        $this->assign('rooms', $rooms);
        return $this->fetch();
    }

    /**
     * 修改注册手机号码
     */
    public function setPhone()
    {
        $source = input('source');
        $back_url = url('User/userSet');
        if(!empty($source)){
            $back_url = url(str_replace('__', '/',$source));
        }
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => $back_url
            ],
            'title' => '修改手机号码',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);

        $this->assign('token', $this->getToken());
        return $this->fetch();
    }

    /**
     * 基础信息设置
     */
    public function setBasicInfo()
    {
        $source = input('source');
        $back_url = url('User/userSet');
        if(!empty($source)){
            $back_url = url(str_replace('__', '/',$source));
        }
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => $back_url
            ],
            'title' => '基础信息',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //获取用户信息
        $request_api = new RequestApi();
        $request_api->api_action = 'resident_info';
        $return_data = $request_api->request_ajax()->getData();
        $user_info = [
            'name' => '',
            'identification' => '',
            'identification_view' => '',
            'uphone' => ''
        ];
        if(isset($return_data['Data']) && isset($return_data['Data']['id'])){
            $user_info = $return_data['Data'];
        }

        $this->assign('user_info', $user_info);
        return $this->fetch();
    }

}