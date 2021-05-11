<?php

namespace services;
require_once "../vendor/aliyun-oss-php-sdk/autoload.php";
use OSS\OssClient;
use OSS\Core\OssException;
class OssService{
   const accessKeyId="";
   const accessKeySecret="";
   const endpoint="";
   const bucket = "";
   public $options = null;
   public function __construct(){
       $this->options = array();
       //$this->options["proxy_url"]="http://username:password@hostname:8080";
   }

   /**
      上传阿里云OSS
      face/tt.file  face是文件架
   **/
   public function upload_file_content($content, $object,$options=[]){
       try {
           $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endpoint);
           if(empty($options)){
              $result=$ossClient->putObject(self::bucket, $object, $content);
           }else{
              $result=$ossClient->putObject(self::bucket, $object, $content,$options);
           }
           if(isset($result['info']['http_code'])){
               return $result['info']['url'];
           }
       } catch (OssException $e) {
           print $e->getMessage();
           return FALSE;
       }
       return TRUE;
   }
   public function delete_file($object){
       try {
           $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endpoint);
           $result=$ossClient->deleteObject(self::bucket,$object);
       } catch (OssException $e) {
           print $e->getMessage();
           return FALSE;
       }
       return TRUE;
   }

   public function download_file($object){
       try {
           $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endpoint);
           $result=$ossClient->getObject(self::bucket,$object);
           return $result;
       } catch (OssException $e) {
           print $e->getMessage();
           return FALSE;
       }
       return FALSE;
   }

}
