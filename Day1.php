<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$puzzleInput = 'R4, R3, R5, L3, L5, R2, L2, R5, L2, R5, R5, R5, R1, R3, L2, L2, L1, R5, L3, R1, L2, R1, L3, L5, L1, R3, L4, R2, R4, L3, L1, R4, L4, R3, L5, L3, R188, R4, L1, R48, L5, R4, R71, R3, L2, R188, L3, R2, L3, R3, L5, L1, R1, L2, L4, L2, R5, L3, R3, R3, R4, L3, L4, R5, L4, L4, R3, R4, L4, R1, L3, L1, L1, R4, R1, L4, R1, L1, L3, R2, L2, R2, L1, R5, R3, R4, L5, R2, R5, L5, R1, R2, L1, L3, R3, R1, R3, L4, R4, L4, L1, R1, L2, L2, L4, R1, L3, R4, L2, R3, L1, L5, R4, R5, R2, R5, R1, R5, R1, R3, L3, L2, L2, L5, R2, L2, R5, R5, L2, R3, L5, R5, L2, R4, R2, L1, R3, L5, R3, R2, R5, L1, R3, L2, R2, R1';
// a = 271
// b = 153
//$puzzleInput = 'R2, L3';
//$puzzleInput = 'R2, R2, R2';
//$puzzleInput = 'R5, L5, R5, R3';
//$puzzleInput = 'R8, R4, R4, R8';

$moves = explode(", ", $puzzleInput);
$currentX = 0;
$currentY = 0;
$facing = 'N';
$history = array();
$grid = array();

for($r=-130;$r<90;$r++) {
    for($c=-10;$c<220;$c++) {
        if(!isset($grid[$r])) $grid[$r] = array();
        $grid[$r][$c] = "#";
    }
}
$grid[0][0] = "S";
function addtoGrid($newCurrentX,$newCurrentY,$facing,&$grid,$icon = NULL) {
    
    if($icon) {
        $icon = "X";
    } elseif($facing=='N') {
        $icon = "^";
    } elseif($facing=='S') {
        $icon = "v";
    } elseif($facing=='E') {
        $icon = "&#62;";
    } else {
        $icon = "&#60;";
    }
    
    $grid[$newCurrentX][$newCurrentY] = $icon;
   
}
function printGrid($currentArray) {
    echo "<code>";
    foreach($currentArray as $rowID => $rowColumn) {
        foreach ($rowColumn as $columnID => $thedata){
           // if($thedata==" ") $thedata = "&nbsp;";
            echo "$thedata";
        }
        echo "<br>";
    }
    echo "</code>";
    
}

foreach($moves as $id => $moveValue) {
    
    $moveValues = str_split($moveValue,1);
    preg_match("/([A-Z]{1})([0-9]{1,3})/",$moveValue,$moveValues);

    $direction = $moveValues[1];
    $length = $moveValues[2];
    
    if($facing=='N' && $direction=='L') {
        // Part 2    
        $facing = 'W';
        for($i=$currentY-1;$i>=$currentY - $length;$i--) {
            $newCurrentX = $currentX;
            $newCurrentY = $i;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
            
        }
        // Turn East        
        $currentX = $currentX + 0;
        $currentY = $currentY - $length;
        
    } elseif($facing=='N' && $direction=='R') {
        // Part 2  
        $facing = 'E';      
        for($i=$currentY+1;$i<=$currentY + $length;$i++) {
            $newCurrentX = $currentX;
            $newCurrentY = $i;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn West
        $currentX = $currentX + 0;
        $currentY = $currentY + $length;
    } elseif($facing=='S' && $direction=='L') {
        // Part 2    
        $facing = 'E';    
        for($i=$currentY+1;$i<=$currentY + $length;$i++) {
            $newCurrentX = $currentX;
            $newCurrentY = $i;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn West
        $currentX = $currentX + 0;
        $currentY = $currentY + $length;
    } elseif($facing=='S' && $direction=='R') {
        // Part 2     
        $facing = 'W';   
        for($i=$currentY-1;$i>=$currentY - $length;$i--) {
            $newCurrentX = $currentX;
            $newCurrentY = $i;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn East
        $currentX = $currentX + 0;
        $currentY = $currentY - $length;
    } elseif($facing=='E' && $direction=='L') {
        // Part 2   
        $facing = 'N';     
        for($i=$currentX-1;$i>=$currentX - $length;$i--) {
            $newCurrentX = $i;
            $newCurrentY = $currentY;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn North
        $currentX = $currentX - $length;
        $currentY = $currentY + 0;
    } elseif($facing=='E' && $direction=='R') {
        // Part 2  
        $facing = 'S';      
        for($i=$currentX+1;$i<=$currentX + $length;$i++) {
            $newCurrentX = $i;
            $newCurrentY = $currentY;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn South
        $currentX = $currentX + $length;
        $currentY = $currentY + 0;
    } elseif($facing=='W' && $direction=='L') {
        // Part 2   
        $facing = 'S';     
        for($i=$currentX+1;$i<=$currentX + $length;$i++) {
            $newCurrentX = $i;
            $newCurrentY = $currentY;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn South
        $currentX = $currentX + $length;
        $currentY = $currentY + 0;
    } elseif($facing=='W' && $direction=='R') {
        // Part 2  
        $facing = 'N';      
        for($i=$currentX-1;$i>=$currentX - $length;$i--) {
            $newCurrentX = $i;
            $newCurrentY = $currentY;
            addtoGrid($newCurrentX,$newCurrentY,$facing,$grid);
            if(in_array("$newCurrentX,$newCurrentY", $history)){
                $blocksAway = abs($newCurrentX) + ($newCurrentY);
                echo "Visited $newCurrentX,$newCurrentY already - $blocksAway<br>";
                addtoGrid($newCurrentX,$newCurrentY,$facing,$grid,1);
            }
            $history[] = "$newCurrentX,$newCurrentY";
        }
        // Turn North
        $currentX = $currentX - $length;
        $currentY = $currentY + 0;
    }
       
}
printGrid($grid);
$finishedDistance = abs($currentX) + ($currentY);
// 195 too low
echo "Finished at location $currentX,$currentY - so thats $finishedDistance blocks<br>";
