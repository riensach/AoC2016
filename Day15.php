<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$puzzleInput = 'Disc #1 has 17 positions; at time=0, it is at position 15.
Disc #2 has 3 positions; at time=0, it is at position 2.
Disc #3 has 19 positions; at time=0, it is at position 4.
Disc #4 has 13 positions; at time=0, it is at position 2.
Disc #5 has 7 positions; at time=0, it is at position 2.
Disc #6 has 5 positions; at time=0, it is at position 0.
Disc #7 has 11 positions; at time=0, it is at position 0.';

//$puzzleInput = 'Disc #1 has 5 positions; at time=0, it is at position 4.
//Disc #2 has 2 positions; at time=0, it is at position 1.';

$puzzleRows = explode("\n",$puzzleInput);

$disks = array();

foreach($puzzleRows as $id => $data) {
    
    $dataSplit = explode(" ", $data);    
    $diskID = str_replace("#", "", $dataSplit[1]);
    $startingPosition = str_replace(".", "", $dataSplit[11]);
    
    $disks[] = array('id' => $diskID, 'positions' => $dataSplit[3], 'startingPosition' => $startingPosition);
    
}

for($i=0;$i<10000000;$i++) {
    $position = 0;
    $disk1Position = ($disks[0]['startingPosition']+$i) % $disks[0]['positions'];
    $disk2Position = ($disks[1]['startingPosition']+$i+1) % $disks[1]['positions'];
    $disk3Position = ($disks[2]['startingPosition']+$i+2) % $disks[2]['positions'];
    $disk4Position = ($disks[3]['startingPosition']+$i+3) % $disks[3]['positions'];
    $disk5Position = ($disks[4]['startingPosition']+$i+4) % $disks[4]['positions'];
    $disk6Position = ($disks[5]['startingPosition']+$i+5) % $disks[5]['positions'];
    $disk7Position = ($disks[6]['startingPosition']+$i+6) % $disks[6]['positions'];
    
    //echo "$i-$disk1Position-$disk2Position-$disk3Position-$disk4Position-$disk5Position-$disk6Position-$disk6Position7<br>";
    if($disk1Position==$disk2Position && $disk1Position==$disk3Position && $disk1Position==$disk4Position  && $disk1Position==$disk5Position && $disk1Position==$disk6Position && $disk1Position==$disk7Position) {
        echo "Passes through on iteration $i (remember to take one) at position $disk1Position<br>";
        die;
    }
    
    
    
}

// too high 400590
// Part A: 400589
// Part B: 3045959







print_r($disks);