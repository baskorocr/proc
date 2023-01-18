<?PHP

function ip_detect()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


function mac_detect(){
    $_IP_SERVER = empty($_SERVER['SERVER_ADDR'])?  $_SERVER['REMOTE_ADDR']:$_SERVER['SERVER_ADDR'];
    $_IP_ADDRESS = $_SERVER['REMOTE_ADDR']; 
    $mac;
    
    if($_IP_ADDRESS == $_IP_SERVER)
    {
        ob_start();
        system('ipconfig /all');
        $_PERINTAH  = ob_get_contents();
        ob_clean();
        $_PECAH = strpos($_PERINTAH, "Physical");
        $_HASIL = substr($_PERINTAH,($_PECAH+36),17);
        //echo $_HASIL;   
        $mac = $_HASIL;
    } else {
        $_PERINTAH = "arp -a $_IP_ADDRESS";
        ob_start();
        system($_PERINTAH);
        $_HASIL = ob_get_contents();
        ob_clean();
        $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
        $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
        $_HASIL = substr($_PECAH_STRING[0], 0, 17);
        //echo "IP Anda : ".$_IP_ADDRESS."
        //MAC ADDRESS Anda : ".$_HASIL;
        $mac = $_HASIL;
    }

    return $mac;
}


    function public_ip(){

        $url = 'https://api.ipify.org/?format=json';
        $content = file_get_contents($url);
        $json = json_decode($content, true);
        $data = $json['ip'];

        /*
         foreach($json as $i){
            echo $i['name'];
         }
         */
    return $data;
    }
/*
$user_ip = ip_detect();

echo $user_ip; // Output IP address [Ex: 177.87.193.134]
*/
?>