<?php
$dir = './ads/';
$files = array_values(array_diff(scandir($dir), array('..', '.','.DS_Store')));
$fname = $files[array_rand($files)];
$output = array('ad_path'=>($dir . $fname));
echo json_encode($output);
?>
