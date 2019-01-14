<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$input = 'yjdafjpo';
$input = 'abc';

$foundthree = 0;
$keys = array();
$tempKey = '';
$tempi = 0;
for($i=0;$i<9995278570;$i++) {
    if($foundthree == 1 && $i <= $tempi+1000) {
        // Check the current hash for a pattern of 5
        $md5hash = strtolower(md5($input.$i));
        preg_match('/(.)\1{4}/',$md5hash,$foundMatches);
        if(count($foundMatches)>0) {
            $keys[] = $tempKey;
            $tempKey = '';
            $i = $tempi;
            $tempi = 0;
            $foundthree = 0;
            echo "FOUND<BR>";
            print_r($foundMatches);
        }
        echo "checking 5 for hash $i - $md5hash<br>";
    } elseif ($foundthree == 1) {
        // Ran out of time, go back to the start
        $i = $tempi;
        $foundthree = 0;
        echo "Ran out of time<br>";
    } elseif($foundthree == 0) {
        // Check the current hash for a pattern of 3
        $md5hash = strtolower(md5($input.$i));
        preg_match('/(.)\1{2}/',$md5hash,$foundMatches);
        if(count($foundMatches)>0) {
            $tempKey = $md5hash;
            $tempi = $i;
            $foundthree = 1;
        }
        echo "checking hash $i - $md5hash - ".count($foundMatches)."<br>";
    }
//    if(count($keys)==64) {
//        echo "Index $i produced the 64th key.";
//    }
//    if(count($keys)>0) {
//        echo "Found ".count($keys)." total keys.<br>";
//        flush();
//        ob_flush();
//    }
}

