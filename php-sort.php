<?php

$a = array(
    23, 12, 123,
);

sort($a);
print_r($a);

sort($a, SORT_STRING);
print_r($a);