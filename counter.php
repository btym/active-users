<?php
    
    $output_as_script = true; //for use on tumblr, avoids origin policy messiness

    $client_ip = $_SERVER['REMOTE_ADDR'];
    $record = geoip_record_by_name($client_ip);
    $ufp = fopen('users.json', 'r+');
    flock($ufp, LOCK_EX);
    $users_file = file_get_contents("users.json");
    $users = json_decode($users_file,true);
    foreach ($users as $u_ip=>&$u_time) {
        if ($u_time + 300 < time()) {
            unset($users[$u_ip]);
        }
    }
    $users[$client_ip] = time();
    file_put_contents('users.json',json_encode($users));
    flock($ufp, LOCK_UN);
    fclose($ufp);
    if ($output_as_script) {
        if (count($users) == 1) {
            echo 'document.getElementById("counter").innerHTML="1 user online <a href=\'/map\'>(map)</a>"';
        } else {
            echo 'document.getElementById("counter").innerHTML="' . count($users) . ' users online <a href=\'/map\'>(map)</a>"';
        }
    } else {
        if (count($users) == 1) {
            echo '1 user online';
        } else {
            echo count($users) . ' users online';
        }
    }