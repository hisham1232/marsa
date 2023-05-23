<?php
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=124.83.111.237"));    
    if($ip_data && $ip_data->geoplugin_countryName != null){
        //echo $ip_data->geoplugin_countryCode;
        $country = $ip_data->geoplugin_countryName;
    }
    echo $country;    
?>