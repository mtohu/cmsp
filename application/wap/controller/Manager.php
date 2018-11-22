<?php
namespace app\wap\controller;

use think\Controller;
use app\wap\logic\Banner;

class Manager extends Base
{
    public function index()
    {
        $nav_item = [
            'index' => '',
            'manager' => 'nav-item-active',
            'user' => ''
        ];
        //banner
        $this->assign('banners', Banner::getBanners());
        $this->assign('nav_item', $nav_item);
        return $this->fetch();
    }

    /**
     * 报修列表
     */
    public function repairList()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Manager/index')
            ],
            'title' => '报修列表',
            'right_btn' => [
                'is_show' => true,
                'btn_name' => '报修',
                'url' => url('Manager/submitRepair')
            ]
        ];
        $this->assign('head', $head);
        //请求数据
        $request_api = new RequestApi();
        $request_api->api_action = 'repair_list';
        $return_data = $request_api->request_ajax()->getData();
        $repair_list = [];
        if(isset($return_data['Data'])){
            $repair_list = $return_data['Data'];
        }

        $this->assign('repair_list', $repair_list);
        return $this->fetch();
    }

    /**
     * 提交报修
     */
    public function submitRepair()
    {
        if($this->request->isAjax()){
            $imgs = input('imgs/a');
            $repair_imgs = [];
            if(!empty($imgs) && count($imgs) > 0){
                $date = date('Ymd');
                $up_dir = '../uploads/' . $date . '/';//存放在当前目录的upload文件夹下
                if(!file_exists($up_dir)){
                    mkdir($up_dir, 0777, true);
                }
                foreach($imgs as $k => $v){
                    if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)){
                        $type = $result[2];
                        if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                            $file_name = md5(date('Y-m-d H:i:s') . rand(0, 999999)) . '.'.$type;
                            $new_file = $up_dir . $file_name;
                            if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $v)))){
                                $repair_imgs[] = '/uploads/' . $date . '/' . $file_name;
                            }
                        }else{
                            //文件类型错误
                            $this->error_data['ErrorCode'] = 1;
                            $this->error_data['ErrorMsg'] = '图片上传类型错误';
                            return $this->print_result($this->error_data);
                        }
                    }else{
                        //文件错误
                        $this->error_data['ErrorCode'] = 1;
                        $this->error_data['ErrorMsg'] = '上传图片错误';
                        return $this->print_result($this->error_data);
                    }
                }
            }
            //报修类型
            $request_api = new RequestApi();
            $request_api->api_action = 'save_repair';
            $request_api->params['repair_type_id'] = input('repair_type_id');
            unset($request_api->params['imgs']);
            $request_api->params['content'] = input('content');
            $request_api->params['img_arr'] = json_encode($repair_imgs);
            $return_data = $request_api->request_ajax()->getData();
            if($return_data['ErrorCode'] != 0){
                return $this->print_result($return_data);
            }

            $this->error_data['ErrorCode'] = 0;
            return $this->print_result($this->error_data);
        }
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Manager/repairList')
            ],
            'title' => '提交报修',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //报修类型
        $request_api = new RequestApi();
        $request_api->api_action = 'add_repair_present';
        $return_data = $request_api->request_ajax()->getData();
        $repair_type = [];
        if(isset($return_data['Data']) && isset($return_data['Data']['repair_type'])){
            $repair_type = $return_data['Data']['repair_type'];
        }
        $this->assign('repair_type', $repair_type);
        return $this->fetch();
    }

    /**
     * 账单列表
     */
    public function feeList()
    {
        $source = input('source');
        $search_txt = input('search_txt');
        $back_url = url('User/index');
        if(!empty($source)){
            $back_url = url(str_replace('__', '/',$source));
        }
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => $back_url
            ],
            'title' => '我的账单',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //账单
        $request_api = new RequestApi();
        $request_api->api_action = 'my_fee_list';
        $request_api->params['search_name'] = $search_txt;
        $return_data = $request_api->request_ajax()->getData();
        $fee_list = [];
        if(isset($return_data['Data'])){
            $fee_list = $return_data['Data'];
        }
//        dump($fee_list);
        $this->assign('fee_list', $fee_list);
        return $this->fetch();
    }

}