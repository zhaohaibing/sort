<?php
//选择排序
$array3 = array(11,-3,51,-7,9,100,2,-56,32,21);
sort_select($array3);
function sort_select($arr) {
   $len = count($arr);
   //外层循环完成所有元素选择
   for($i = 0; $i < $len; $i++) {
      $minInx = $i;
      //内层循环选择一个最小元素的位置
      for($j = $i; $j < $len; $j++) {
         if($arr[$minInx] > $arr[$j]) {
            $minInx = $j;
         }
      }
      //交换最小元素到有序队列尾部
      if ($i != $minInx) {
         $tmp = $arr[$i];
         $arr[$i] = $arr[$minInx];
         $arr[$minInx] = $tmp;
      }
   }
   foreach ($arr as $value){
   	  echo $value.' ';
   }
}