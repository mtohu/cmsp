<?php
class WeLoader{
    public static function loadClass($class){
        $arr=explode("\\", $class);
        $class_name = $arr[count($arr)-1];
        $directorys = array(
            '/support/',
            '/base/',
            '/src/',
            //'/../tp_master/',
        );
        foreach($directorys as $directory){
            $file = WECHAT_ROOT.$directory.$class_name.'.php';
            if (is_file($file)) {
                require_once($file);
            }
        }
    }
}
spl_autoload_register(array('WeLoader', 'loadClass'),true,true);
?>
