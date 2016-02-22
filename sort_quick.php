<?php
//快速排序
function sort_quick($arr){
  //递归到只有一个元素
   if (count($arr) <= 1){
       return $arr;
   }
   $key = $arr[0];
   $left_arr = array();
   $right_arr = array();
   //左边数组都比右边数组元素小
   for($i=1; $i < count($arr); $i++){
       if($arr[$i] <= $key){
           $left_arr[] = $arr[$i];
       } else {
           $right_arr[] = $arr[$i];
       }
   }
   //递归对左右数组分别排序
   $left_arr = sort_quick($left_arr);
   $right_arr = sort_quick($right_arr);
   //合并结果
   return array_merge($left_arr, array($key), $right_arr);
}

$arr = array(11,-3,51,-7,9,100,2,-56,32,21);
$arr2= sort_quick($arr);
foreach ($arr2 as $key=>$value){
   echo $value." ";
}
