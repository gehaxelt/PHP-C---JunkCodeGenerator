<?php
include_once 'junkcode.class.php';

$junkCC = new JunkCodeClass();
echo $junkCC->getHeaderCode();
echo $junkCC->getClassCode();
unset($junkCC);


?>