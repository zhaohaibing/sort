<?php

$a = array(
    'a' => array("l" => "A", "n" => 1),
    'b' => array("l" => "B", "n" => 2),
    'c' => array("l" => "C", "n" => 1),
    'd' => array("l" => "D", "n" => 2),
    'e' => array("l" => "E", "n" => 2),
);

uasort($a, 'cmp');
print_r($a);

function cmp($a, $b) {
    if($a['n'] == $b['n']) {
        return 0;
    }
    return ($a['n'] > $b['n']) ? -1 : 1;
}







function cmp2($a, $b) {
    if($a['n'] == $b['n']) {
        if ($a['l'] == $b['l']) {
         return 0;
      }
      else {
         return $a['l'] > $b['l'] ? -1 : 1;
      }
    }
    return ($a['n'] > $b['n']) ? -1 : 1;
}
