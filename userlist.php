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
        if ($record['city'] == '') {
            $record['city'] = 'Unknown city';
        }
        if ($u_ip == $_SERVER['REMOTE_ADDR']) {
            echo $record['city'] . ': that\'s you!</br>';
            continue;
        }
        $last_seen = time() - $u_time;
        if ($last_seen > 299){
            continue;
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