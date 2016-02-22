<?php
//桶排序
$arr = array(11,3,51,7,9,100,2,56,32,21);
$arr = sort_bucket($arr);
foreach ($arr as $value){
        echo $value.' ';
}

function sort_bucket($array){
  //1首先产生两个数字，即最大值和最小值，然后利用两个数据产生木桶装装载数据
  $min = $array[0];
  $max = $array[0];
  $len = (int)count($array);
  for($i=1;$i<$len;++$i){
     if($array[$i]<$min){
       $min = $array[$i];
     }elseif($array[$i]>$max){
     $max = $array[$i];
     }
  }
  //产生桶
  $buckets = array_fill($min,$max-$min+1,0);
  //2统计出现的次数（在桶内统计出次数）
  foreach($array as $v){
   ++$buckets[$v];
  }
  //3把桶内的数据输出来
  foreach($buckets  as $k=>$v){
     for($i=1;$i<=$v;++$i){
     $res[] = $k;
        }
    }
    return $res;
}