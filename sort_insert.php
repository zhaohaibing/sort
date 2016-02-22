<?php
//插入排序
$array = array(11,-3,51,-7,9,100,2,-56,32,21);
sort_insert($array);
function sort_insert($arr) {
  //外层循环完成所有数的插入
   for ($i = 1;$i < count($arr);$i++){
       $insertVal = $arr[$i];
       $insertIndex = $i - 1;
       //内层循环把大于插入数的都后移，直到插入位置
       while ($insertIndex >=0 && $insertVal < $arr[$insertIndex]){
       	  $arr[$insertIndex + 1] = $arr[$insertIndex];
       	  $insertIndex--;
       }
       //找到插入位置
       $arr[$insertIndex + 1] = $insertVal;
   }
   foreach ($arr as $value){
   	  echo $value.' ';
   }
}