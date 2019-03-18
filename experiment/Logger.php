<?php
$data = $_POST['data'];
$jsLog = json_decode($data,true);
$fname = "./logs/userIp" . $jsLog['userIp'] . ".json";
$myfile = fopen($fname,w) or die("Can't create file");
fwrite($myfile,json_encode($jsLog, JSON_PRETTY_PRINT));
fclose($myfile);
?>
