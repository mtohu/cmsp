<?php
namespace app\wap\logic;

use app\wap\controller\RequestApi;
use think\Db;

class Banner
{
    public static function getBanners()
    {
        $request_api = new RequestApi();
        $request_api->api_action = 'banner_list';
        $return_data = $request_api->request_ajax()->getData();

        $banners = $return_data['Data'];
        if(count($banners) == 0){
            $banners = [
                [
                    'pics' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542537772804&di=d9187a578d40dd52afce9401ec554042&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimgad%2Fpic%2Fitem%2F34fae6cd7b899e51ef51f53949a7d933c9950dc4.jpg',
                    'link_url' => '/wap'
                ],
                [
                    'pics' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1542537795770&di=999e8270db84ad6abcbf3ea69f815590&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01a21d575a17770000018c1bb53779.jpg',
                    'link_url' => '/wap'
                ]
            ];
        }
        return $banners;
    }
}