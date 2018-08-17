<?php
$str =md5(microtime());
$str=substr($str,0,8);
session_start();
$_SESSION['cap_code']=$str;
$img =imagecreate(100,20);
imagecolorallocate($img,255,255,255);
$txcol=imagecolorallocate($img,220,20,60);
imagestring($img,20,5,5,$str,$txcol);
imagejpeg($img);
?>