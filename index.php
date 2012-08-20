<?php
include_once 'junkcode.class.php';

$junkCC = new JunkCodeClass();
echo "<code><pre>";
echo htmlentities($junkCC->getHeaderCode());
echo "</pre></code>";

echo "<br><br>";

echo "<code><pre>";
echo htmlentities($junkCC->getClassCode());
echo "</pre></code>";

unset($junkCC);


?>