<?php
$data = $_POST['data'];
$params = json_decode($data,true);
$alg = $params['alg'];
$max_p = $params['max_p'];
$output = exec("python script.py ".$alg." ".$max_p);
echo $output;
?>
