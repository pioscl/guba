<?php
$out = shell_exec('sudo /Users/xuchang/anaconda/bin/python3.6 tmp.py '.$_GET['code'].' 2>&1');
echo $out;
?>