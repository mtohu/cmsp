<?php
namespace app\wap\logic;

class Img
{
    private $basePath = '/uploads/';
    private $maxImgWidth;
    private $maxImgHeight;

    public function __construct($maxImgWidth=500, $maxImgHeight=500)
    {
        $this->maxImgWidth = $maxImgWidth;
        $this->maxImgHeight = $maxImgHeight;
    }

    public function newImgName($type)
    {
        $date = date('Ymd');
        $up_dir = '..' . $this->basePath . $date . '/';//存放在当前目录的upload文件夹下
        if(!file_exists($up_dir)){
            mkdir($up_dir, 0777, true);
        }
        $file_name = md5(date('Y-m-d H:i:s') . rand(0, 999999)) . '.' . $type;
        return $this->basePath . $date . '/' . $file_name;
    }

    /**
     * 创建新图片
     */
    public function createNewImg($base64Txt)
    {
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Txt, $result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = '..' . $this->newImgName($type);
                if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64Txt)))){
                    $compress_new_file = $this->newImgName($type);
                    $this->compressImg($new_file, '..' . $compress_new_file);
                    return $compress_new_file;
                }
            }
        }
        return '';
    }

    /**
     * 裁剪图片
     */
    public function compressImg($imgUrl, $newImgUrl)
    {
        $image = \think\Image::open($imgUrl);
        $image->thumb($this->maxImgWidth, $this->maxImgHeight)->save($newImgUrl);
        @unlink($imgUrl);
    }
}