<?php

    $mapW = 500;
    $mapH = 500;
    $pointW = 5;
    $pointH = 5;
    
    $map = imagecreatefrompng('map.png');
    $point = imagecreatefrompng('point.png');
    $record = geoip_record_by_name($client_ip);
    $ufp = fopen('users.json', 'r+');
    flock($ufp, LOCK_EX);
    $users_file = file_get_contents("users.json");
    $users = json_decode($users_file,true);
    flock($ufp, LOCK_UN);
    fclose($ufp);
    foreach ($users as $u_ip=>$time) {
        $record = geoip_record_by_name($u_ip);
        $x = ($record['longitude']+180)*($mapW/360);
        $latRad = $record['latitude']*pi()/180;
        $mercN = log(tan((pi()/4)+($latRad/2)));
        $y = ($mapH/2)-($mapW*$mercN/(2*pi()));
        imagecopy($map, $point, $x-$pointW/2, $y-$pointH/2, 0, 0, $pointW, $pointH);
    }
    
    header('Content-Type: image/png');
    imagepng($map);