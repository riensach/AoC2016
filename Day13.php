<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require __DIR__ . '/vendor/autoload.php';
use Letournel\PathFinder\Algorithms;
use Letournel\PathFinder\Converters\Grid\ASCIISyntax;
use Letournel\PathFinder\Core;
use Letournel\PathFinder\Distances;



$createdGrid = array();
$favNumber = 1364;
//$favNumber = 10;

for($c=0;$c<=200;$c++) {
    for($r=0;$r<=200;$r++) {
        if(!isset($createdGrid[$c])) $createdGrid[$c] = array();
        $createdGrid[$c][$r] = '#';
    }    
}

for($c=0;$c<=200;$c++) {
    for($r=0;$r<=200;$r++) {
        $calculation = ($c*$c + 3*$c + 2*$c*$r + $r + $r*$r) + $favNumber;
            $info = "$c,$r - $calculation  - " . decbin($calculation) . " - ";
        $number1Count = substr_count(decbin($calculation),1);
        if($number1Count % 2 == 0) {
            $info .= "even <br>";
            $createdGrid[$c][$r] = '.';
        } else {
            $info .= "odd <br>";
            $createdGrid[$c][$r] = '#';
        }
        //echo $info;
    }
}

$distance = new Distances\Manhattan();
$heuristic = new Core\Heuristic(new Distances\Manhattan(), 1);
//echo "$c,$r<br>";
$cavernArrayMap = prepareCavern($createdGrid, 1, 1, 31, 39);

//$cavernArrayMap = prepareCavern($createdGrid, 1, 1, 7, 4);
$cavernArrayMap = returnGrid($cavernArrayMap);



$foundPath = findPath($cavernArrayMap, new Algorithms\ShortestPath\Dijkstra($distance, $heuristic));
if(is_array($foundPath)) {
    $possibleTargets[] = array_merge($foundPath[0],array('targetRow' =>31,'targetColumn' =>39));
}

// Part A = 86
// 120 too low

$targetCount = count($possibleTargets);
echo "$targetCount - <br>";


print_r($possibleTargets);

echo "<br>";



printGrid($createdGrid);



function printGrid($currentArray) {
    echo "<code>";
    foreach($currentArray as $rowID => $rowColumn) {
        foreach ($rowColumn as $columnID => $thedata){
            if($thedata==" ") $thedata = "&nbsp;";
            echo "$thedata ";
        }
        echo "<br>";
    }
    echo "</code>";
    
}











function prepareCavern($cavernArray, $startingRow, $startingColumn, $targetRow, $targetColumn) {
    
    $possibleCavern = array();
    foreach($cavernArray as $possibleTargetRow => $rowColumn) {
        foreach ($rowColumn as $possibleTargetColumn => $gridValue){
            if($possibleTargetRow==$targetRow && $possibleTargetColumn==$targetColumn) {
                $possibleCavern[$possibleTargetRow][$possibleTargetColumn] = '<'; 
            } elseif($possibleTargetRow==$startingRow && $possibleTargetColumn==$startingColumn) {
                $possibleCavern[$possibleTargetRow][$possibleTargetColumn] = '>';  
            } elseif($cavernArray[$possibleTargetRow][$possibleTargetColumn]=="G" || $cavernArray[$possibleTargetRow][$possibleTargetColumn]=="E") {
                $possibleCavern[$possibleTargetRow][$possibleTargetColumn] = 'X';  
            } elseif($cavernArray[$possibleTargetRow][$possibleTargetColumn]==".") {
                $possibleCavern[$possibleTargetRow][$possibleTargetColumn] = '.';  
            } else {
                $possibleCavern[$possibleTargetRow][$possibleTargetColumn] = 'X'; 
            }
            
        }
        
    }
    return $possibleCavern;
}



function returnGrid($currentArray) {
    $var = "";
    foreach($currentArray as $rowID => $rowColumn) {
        foreach ($rowColumn as $columnID => $thedata){
           // if($thedata==" ") $var .= "&nbsp;";
            $var .= "$thedata";
        }
        $var .= "\n";
    }
    $var .= "";
    return $var;
    
}


function findPath($map, $algorithm)
{
        $converter = new ASCIISyntax();
        $grid = $converter->convertToGrid($map);
        $matrix = $converter->convertToMatrix($map);
        $source = $converter->findAndCreateNode($matrix, ASCIISyntax::IN);
        $target = $converter->findAndCreateNode($matrix, ASCIISyntax::OUT);
        
        $algorithm->setGrid($grid);
        //$starttime = microtime(true);
        $path = $algorithm->computePath($source, $target);
        
        //$endtime = microtime(true);
        
        if($path instanceof Core\NodePath)
        {
            $length = $algorithm->computeLength($source, $target);
            //echo "Path found in " . floor(($endtime - $starttime) * 1000) . " ms\n - ";
            $path->next();
            //echo $path->key()." - $length<br>\n";
            //echo $converter->convertToSyntaxWithPath($grid, $path);
            //echo "<br>";

            $pathGrid = explode(',',$path->key());
            return array(0 => array('length' => $length, 'nextMove' => $path->key(), 'row' => $pathGrid[0], 'column' => $pathGrid[1]));

        }
        else
        {
            return 0;
            //echo "No path found\n";
        }
    }
    
    
    
    
    
    
    
    
    
