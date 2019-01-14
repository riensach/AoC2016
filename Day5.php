<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$input = 'ugkcyxxp';

//$input = 'abc';
// 05ace8e3
$time_pre = microtime(true);
$password = '';
$password2 = array();
for($i=0;$i<9995278570;$i++) {
    $md5hash = md5($input.$i);
    if(substr($md5hash, 0, 5)==='00000') {
        //Found the hash
        if(strlen($password)<8) {
            $password .= substr($md5hash, 5, 1);   
        }
        if(is_numeric(substr($md5hash, 5, 1)) && substr($md5hash, 5, 1) < 8 && substr($md5hash, 5, 1) > -1 && !isset($password2[substr($md5hash, 5, 1)])){
            $password2[substr($md5hash, 5, 1)] = substr($md5hash, 6, 1);
        }
        //echo "Found the hash - $i - $md5hash - ".substr($md5hash, 0, 5)." - $password<br>";
    }
    //echo count($password);
    if(strlen($password)>7 && count($password2)==8) {
        break;
    }
    if($i % 1000000 == 0) {
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "Done loop $i - password so far is $password<br>";
        flush();
        ob_flush();
    }
}
$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
$password2String = '';
ksort($password2);
foreach ($password2 as $key => $value) {
    $password2String .= $value;
}
echo "Found the password - $password. Completed after $exec_time. Found the part2 password: $password2String";
flush();
ob_flush();