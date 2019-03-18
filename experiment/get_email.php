<?php
$options = array('spam','ham');
$type = $options[array_rand($options)];
$dir = './emails/' . $type;
$files = array_values(array_diff(scandir($dir), array('..', '.')));
$fname = $files[array_rand($files)];
$output = array('type'=>$type,'fname'=>$fname);
echo json_encode($output);
?>
