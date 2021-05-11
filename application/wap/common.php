<?php
function request_data($url,$postData='',$headers=''){
    $str  = array(
        "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-TW; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7 GTBDFff GTB7.0 (.NET CLR 3.5.30729)",
        "Connection: Keep-Alive",
        "Cache-Control: no-cache");
    if(is_array($headers)){
        foreach($headers as $k => $v){
            $str[]=$k.":".$v;
        }
    }
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl,CURLOPT_HTTPHEADER, $str);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30); //timeout on connect
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout on response
    if(is_array($postData)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    curl_setopt($curl,CURLOPT_URL,$url);
    $html = curl_exec($curl);
    // var_dump($html);exit;
    curl_close($curl);
    return $html;
}
