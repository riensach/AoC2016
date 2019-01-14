<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$puzzleInput = 'rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 6
rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 2
rect 1x1
rotate row y=0 by 5
rect 2x1
rotate row y=0 by 2
rect 1x1
rotate row y=0 by 4
rect 1x1
rotate row y=0 by 3
rect 2x1
rotate row y=0 by 7
rect 3x1
rotate row y=0 by 3
rect 1x1
rotate row y=0 by 3
rect 1x2
rotate row y=1 by 13
rotate column x=0 by 1
rect 2x1
rotate row y=0 by 5
rotate column x=0 by 1
rect 3x1
rotate row y=0 by 18
rotate column x=13 by 1
rotate column x=7 by 2
rotate column x=2 by 3
rotate column x=0 by 1
rect 17x1
rotate row y=3 by 13
rotate row y=1 by 37
rotate row y=0 by 11
rotate column x=7 by 1
rotate column x=6 by 1
rotate column x=4 by 1
rotate column x=0 by 1
rect 10x1
rotate row y=2 by 37
rotate column x=19 by 2
rotate column x=9 by 2
rotate row y=3 by 5
rotate row y=2 by 1
rotate row y=1 by 4
rotate row y=0 by 4
rect 1x4
rotate column x=25 by 3
rotate row y=3 by 5
rotate row y=2 by 2
rotate row y=1 by 1
rotate row y=0 by 1
rect 1x5
rotate row y=2 by 10
rotate column x=39 by 1
rotate column x=35 by 1
rotate column x=29 by 1
rotate column x=19 by 1
rotate column x=7 by 2
rotate row y=4 by 22
rotate row y=3 by 5
rotate row y=1 by 21
rotate row y=0 by 10
rotate column x=2 by 2
rotate column x=0 by 2
rect 4x2
rotate column x=46 by 2
rotate column x=44 by 2
rotate column x=42 by 1
rotate column x=41 by 1
rotate column x=40 by 2
rotate column x=38 by 2
rotate column x=37 by 3
rotate column x=35 by 1
rotate column x=33 by 2
rotate column x=32 by 1
rotate column x=31 by 2
rotate column x=30 by 1
rotate column x=28 by 1
rotate column x=27 by 3
rotate column x=26 by 1
rotate column x=23 by 2
rotate column x=22 by 1
rotate column x=21 by 1
rotate column x=20 by 1
rotate column x=19 by 1
rotate column x=18 by 2
rotate column x=16 by 2
rotate column x=15 by 1
rotate column x=13 by 1
rotate column x=12 by 1
rotate column x=11 by 1
rotate column x=10 by 1
rotate column x=7 by 1
rotate column x=6 by 1
rotate column x=5 by 1
rotate column x=3 by 2
rotate column x=2 by 1
rotate column x=1 by 1
rotate column x=0 by 1
rect 49x1
rotate row y=2 by 34
rotate column x=44 by 1
rotate column x=40 by 2
rotate column x=39 by 1
rotate column x=35 by 4
rotate column x=34 by 1
rotate column x=30 by 4
rotate column x=29 by 1
rotate column x=24 by 1
rotate column x=15 by 4
rotate column x=14 by 1
rotate column x=13 by 3
rotate column x=10 by 4
rotate column x=9 by 1
rotate column x=5 by 4
rotate column x=4 by 3
rotate row y=5 by 20
rotate row y=4 by 20
rotate row y=3 by 48
rotate row y=2 by 20
rotate row y=1 by 41
rotate column x=47 by 5
rotate column x=46 by 5
rotate column x=45 by 4
rotate column x=43 by 5
rotate column x=41 by 5
rotate column x=33 by 1
rotate column x=32 by 3
rotate column x=23 by 5
rotate column x=22 by 1
rotate column x=21 by 2
rotate column x=18 by 2
rotate column x=17 by 3
rotate column x=16 by 2
rotate column x=13 by 5
rotate column x=12 by 5
rotate column x=11 by 5
rotate column x=3 by 5
rotate column x=2 by 5
rotate column x=1 by 5';


/*$puzzleInput = 'rect 3x2
rotate column x=1 by 1
rotate row y=0 by 4
rotate column x=1 by 4';
 * 
 */

$puzzleRows = explode("\n",$puzzleInput);

$screen = array();
for($r=0;$r<6;$r++) {
    for($c=0;$c<50;$c++) {
        if(!isset($screen[$r])) $screen[$r] = array();
        $screen[$r][$c] = ".";
    }
}


foreach($puzzleRows as $rowID => $puzzleRow) {
    $rowArray = explode(" " , $puzzleRow);
    if($rowArray[0]=='rect') {
        drawRect($screen,$rowArray[1]);
    } elseif($rowArray[0]=='rotate' && $rowArray[1]=='column') {
        $startArray = explode("=" , $rowArray[2]);
        rotatePixelsColumn($screen, $startArray[1], $rowArray[4]);
    } elseif($rowArray[0]=='rotate' && $rowArray[1]=='row') {
        $startArray = explode("=" , $rowArray[2]);
        rotatePixelsRow($screen, $startArray[1], $rowArray[4]);
    }
    //printGrid($screen);
   // echo "<br><Br>";
}
printGrid($screen);

$litPixels = 0;

for($r=0;$r<6;$r++) {
    for($c=0;$c<50;$c++) {
        if($screen[$r][$c]=='#') $litPixels++;
    }
}

echo "<br>Finished. A total of $litPixels are lit.<br>";
// PArt 2 was done with how I solved part 1
// A = 115
// B = EFEYKFRFIJ;



function rotatePixelsRow(&$screen, $startCoord, $length) {
    $oldScreen = $screen;    
    for($c=0;$c<50;$c++) {
        $colPosition = (($c-$length)<0) ? 50+$c-$length:$c-$length;
        $screen[$startCoord][$c] = $oldScreen[$startCoord][$colPosition];
    }

}

function rotatePixelsColumn(&$screen, $startCoord, $length) {
    $oldScreen = $screen;    
    for($r=0;$r<6;$r++) {
        $colPosition = (($r-$length)<0) ? 6+$r-$length:$r-$length;
        $screen[$r][$startCoord] = $oldScreen[$colPosition][$startCoord];
    }

}




function drawRect(&$screen, $dims) {
    $dimensions = explode("x",$dims);
    
    for($r=0;$r<$dimensions[1];$r++) {
        for($c=0;$c<$dimensions[0];$c++) {
            $screen[$r][$c] = "#";
        }
    }
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