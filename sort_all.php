<?php

test();
function test() {
  $arr = array(); 
  for ($i=0; $i<1000; $i++)
  {
    $arr[$i] = rand(0,10000000);
  }
  //sort($arr);

  sort_bubble($arr);
  sort_select($arr);
  sort_insert($arr);

  $t = microtime(true);
  global $cmpcount, $chgcount;
  $cmpcount = 0; $chgcount = 0;
  sort_quick($arr);
  $time = microtime(true) - $t;
  echo sprintf("quick : cmp:%8d, chg:%8d, time:%01.3f\n", $cmpcount, $chgcount, $time);
}

function sort_bubble($arr) {
  $t = microtime(true); $cmpcount = 0; $chgcount = 0;
  $flag = false;
  $num = count($arr);
  for ($i = 1; $i < $num; $i++) {
    for ($j = 0; $j < $num - $i; $j++) {
      if ($arr[$j] > $arr[$j + 1]) {
        $temp = $arr[$j];
        $arr[$j] = $arr[$j + 1];
        $arr[$j + 1] = $temp;
        $flag = true;
        $chgcount += 1;
      }
      $cmpcount += 1;
    }
    if (!$flag){
      break;
    }
    $flag = false;
  }
  $time = microtime(true) - $t;
  echo sprintf("bubble: cmp:%8d, chg:%8d, time:%01.3f\n", $cmpcount, $chgcount, $time);
}
function sort_select($arr) {
  $t = microtime(true); $cmpcount = 0; $chgcount = 0;
   $len = count($arr);
   for($i = 0; $i < $len; $i++) {
      $minInx = $i;
      for($j = $i; $j < $len; $j++) {
         if($arr[$minInx] > $arr[$j]) {
            $minInx = $j;
         }
         $cmpcount += 1;
      }
      if ($i != $minInx) {
        $tmp = $arr[$i];
        $arr[$i] = $arr[$minInx];
        $arr[$minInx] = $tmp;
        $chgcount += 1;
      }
   }
   $time = microtime(true) - $t;
   echo sprintf("select: cmp:%8d, chg:%8d, time:%01.3f\n", $cmpcount, $chgcount, $time);
}
function sort_insert($arr) {
  $t = microtime(true); $cmpcount = 0; $chgcount = 0;
   for ($i = 1;$i < count($arr);$i++){
       $insertVal = $arr[$i];
       $insertIndex = $i - 1;
       while ($insertIndex >=0 && $insertVal < $arr[$insertIndex]){
       	  $arr[$insertIndex + 1] = $arr[$insertIndex];
       	  $insertIndex--;
          $cmpcount += 1;
          $chgcount += 1;
       }
       $arr[$insertIndex + 1] = $insertVal;
       $chgcount += 1;
   }
   $time = microtime(true) - $t;
   echo sprintf("insert: cmp:%8d, chg:%8d, time:%01.3f\n", $cmpcount, $chgcount, $time);
}

function sort_quick($arr){
  global $cmpcount, $chgcount;
   if (count($arr) <= 1){
       return $arr;
   }
   $key = $arr[0];
   $left_arr = array();
   $right_arr = array();
   for($i=1; $i < count($arr); $i++){
       if($arr[$i] <= $key){
           $left_arr[] = $arr[$i];
       } else {
           $right_arr[] = $arr[$i];
       }
       $cmpcount += 1;
       $chgcount += 1;
   }
   $left_arr = sort_quick($left_arr);
   $right_arr = sort_quick($right_arr);
   return array_merge($left_arr, array($key), $right_arr);
}

