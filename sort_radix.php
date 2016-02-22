<?php
//基数排序
$arr = array(11,3,51,7,9,100,2,56,32,21);
sort_radix($arr);
foreach ($arr as $value){
        echo $value.' ';
}

#基数排序,以计数排序作为子排序过程
function sort_radix(&$arr) {
   #先求出数组中最大的位数
   $max = max($arr);
   $max_digit = get_digit($max);

   for ($i = 1; $i <= $max_digit; $i++) {
       counting_sort($arr, $i);
   }   
}

function counting_sort(&$arr, $digit_num = false) {
   if ($digit_num !== false) { 
       for ($i = 0; $i < count($arr); $i++) {
           $arr_temp[$i] = get_specific_digit($arr[$i], $digit_num);
       } 
   } else {
       $arr_temp = $arr;
   }

   $max = max($arr);
   $time_arr = array(); #储存元素出现次数的数组

   #初始化出现次数数组
   for ($i = 0; $i <= $max; $i++) {
       $time_arr[$i] = 0;
   }

   #统计每个元素出现次数
   for ($i = 0; $i < count($arr_temp); $i++) {
       $time_arr[$arr_temp[$i]]++;
   }

   #统计每个元素比其小或相等的元素出现次数
   for ($i = 0; $i < count($time_arr) - 1; $i++) {
       $time_arr[$i + 1] += $time_arr[$i];
   }

   #利用出现次数对数组进行排序
   for($i = count($arr) - 1; $i >= 0; $i--) {
       $sorted_arr[$time_arr[$arr_temp[$i]] - 1] = $arr[$i];
       $time_arr[$arr_temp[$i]]--;
   }

   $arr = $sorted_arr;
   ksort($arr);    #忽略这次对key排序的效率损耗
}

#计算某个数的位数
function get_digit($number) {
  $i = 1;
  while ($number >= pow(10, $i)) {
     $i++;
  }

  return $i;
}

#获取某个数字的从个位算起的第i位数
function get_specific_digit($num, $i) {
  if ($num < pow(10, $i - 1)) {
      return 0;
  }
  return floor($num % pow(10, $i) / pow(10, $i - 1));
}

