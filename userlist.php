<?php

    $output_as_script = true; //for use on tumblr, avoids origin policy messiness

    $ufp = fopen('users.json', 'r+');
    flock($ufp, LOCK_EX);
    $users_file = file_get_contents("users.json");
    flock($ufp, LOCK_UN);
    fclose($ufp);
    $users = json_decode($users_file,true);
    
    if ($output_as_script) {
        echo 'document.write("';
    }
    foreach ($users as $u_ip=>$u_time) {
        $record = geoip_record_by_name($u_ip);
        $last_seen = time() - $u_time;
        if ($record['city'] == '') {
            $record['city'] = 'Unknown city';
        }
        echo $record['city'] . ': ' .$last_seen .' second';
        if ($last_seen != 1){
            echo 's';
        }
        echo ' ago<br>';
    }
    if ($output_as_script) {
        echo '")';
    }