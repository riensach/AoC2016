<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$puzzleInput = 'cpy 1 a
cpy 1 b
cpy 26 d
jnz c 2
jnz 1 5
cpy 7 c
inc d
dec c
jnz c -2
cpy a c
inc a
dec b
jnz b -2
cpy c b
dec d
jnz d -6
cpy 17 c
cpy 18 d
inc a
dec d
jnz d -2
dec c
jnz c -5';

/*$puzzleInput = 'cpy 41 a
inc a
inc a
dec a
jnz a 2
dec a';
 * 
 */

$puzzleRows = explode("\n",$puzzleInput);
$registerValues = array('a'=>0,'b'=>0,'c'=>1,'d'=>0);
$time_pre = microtime(true);
$instructionID = 0;
$iterations = 0;
$maxInsturctions = count($puzzleRows);
while($instructionID < $maxInsturctions) {
    $value = $puzzleRows[$instructionID];
    $values = explode(" ", $value);
    $instruction = $values[0];    
    
    if($instruction=='cpy') {        
        // cpy x y copies x (either an integer or the value of a register) into register y.        
        if(is_numeric($values[1])) {            
            $registerValues[$values[2]] = $values[1];
            $action = "Copy value ".$values[1]." to register ".$values[2]."<br>";
        } else {            
            $registerValues[$values[2]] = $registerValues[$values[1]];
            $action = "Copy value ".$registerValues[$values[1]]." (from register ".$values[1].") to register ".$values[2]."<br>";
        }       
    } elseif($instruction=='inc') {
        // inc x increases the value of register x by one.
        $registerValues[$values[1]] = $registerValues[$values[1]]+1;
        $action = "Increase register ".$values[1]." by 1 - ".$registerValues[$values[1]]."<br>";
    } elseif($instruction=='dec') {
        // dec x decreases the value of register x by one.        
        $registerValues[$values[1]] = $registerValues[$values[1]]-1;
        $action = "Decrease register ".$values[1]." by 1 - ".$registerValues[$values[1]]."<br>";
    } elseif($instruction=='jnz') {
        // jnz x y jumps to an instruction y away (positive means forward; negative means backward), but only if x is not zero.
        if(is_numeric($values[1]) && $values[1] != 0) {  
            $instructionID = $instructionID + $values[2] -1;            
            $action = "Jump to instruction $instructionID (".$values[2].")<br>";
        } elseif($registerValues[$values[1]]!=0) {
            $instructionID = $instructionID + $values[2] -1;            
            $action = "Jump to instruction $instructionID (".$values[2].")<br>";
        } else {
            $action = "Do nothing because X is set to ".$values[1]."<br>";
        }
    } else {
        $action = "Problem - $instruction.<br>";
    }
    //echo $action;
    $instructionID++;
    $iterations++;
    if($iterations % 1000000 == 0) {
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        echo "Done iteration $iterations in $exec_time seconds<Br>";
        flush();
        ob_flush();
    }
}

print_r($registerValues);

// A = 318117 

// B = 9227771 