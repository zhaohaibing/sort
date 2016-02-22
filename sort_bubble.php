<?php
//冒泡排序
$array = array(11,-3,51,-7,9,100,2,-56,32,21);

sort_bubble($array);

function sort_bubble($arr) {
  $flag = false;
  $num = count($arr);
  //外层循环，依次对所有元素排序
  for ($i = 1; $i < $num; $i++) {
    //内层循环，每次移动一个元素到有序序列尾部
    for ($j = 0; $j < $num - $i; $j++) {
      //大的元素往后移
      if ($arr[$j] > $arr[$j + 1]) {
        $temp = $arr[$j];
        $arr[$j] = $arr[$j + 1];
        $arr[$j + 1] = $temp;
        $flag = true;
      }
    }
    if (!$flag){
      break;
    }
    $flag = false;
  }
  foreach ($arr as $value){
  echo $value.' ';
  }
}