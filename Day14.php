<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$input = 'yjdafjpo';
//$input = 'abc';

$foundthree = 0;
$keys = array();
$tempKey = '';
$foundKey = '';
$tempi = 0;
$debug = '';
$time_pre = microtime(true);
$savedHashes = array();
$iterations = 0;
for($i=0;$i<9995278570;$i++) {
    if($foundthree == 1 && $i <= ($tempi + 1000)) {
        // Check the current hash for a pattern of 5
        if(!isset($savedHashes[$i])) {
            $md5hash = strtolower(md5($input.$i));
            $savedHashes[$i] = $md5hash;
        }
        $debug = "checking 5 for $foundKey for hash $i - $md5hash<br>";
        preg_match('/('.$foundKey.')\1{4}/',$savedHashes[$i],$foundMatches);
        if(count($foundMatches)>0) {
            $keys[] = $tempKey;
            $tempKey = '';
            $i = $tempi;
            $tempi = 0;
            $foundthree = 0;
        }
        
    } elseif ($foundthree == 1) {
        // Ran out of time, go back to the start
        $i = $tempi;
        $foundthree = 0;
        $debug .= "Ran out of time<br>";
    } elseif($foundthree == 0) {
        // Check the current hash for a pattern of 3
        if(!isset($savedHashes[$i])) {
            $md5hash = strtolower(md5($input.$i));
            $savedHashes[$i] = $md5hash;
        }
        preg_match('/(.)\1{2}/',$savedHashes[$i],$foundMatches);
        if(count($foundMatches)>0) {
            $tempKey = $md5hash;
            $tempi = $i;
            $foundKey = substr($foundMatches[0],0,1);
            $foundthree = 1;
        }
        $debug .= "checking hash $i - $md5hash - ".count($foundMatches)."<br>";
    }
    if(count($keys)==64) {
        echo "Index $i produced the 64th key.";
        break;
    }
    $iterations++;
    if($iterations % 10000 == 0) {
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "Done iteration $iterations in $exec_time seconds<Br>";
        flush();
        ob_flush();
    }
    //echo $debug;
//    if(count($keys)>0) {
//        echo "Found ".count($keys)." total keys.<br>";
//        flush();
//        ob_flush();
//    }
}

