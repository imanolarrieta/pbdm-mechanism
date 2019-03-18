<?php
$maxDots = intval($_REQUEST["numberOfDotsMax"]);
$minDots = intval($_REQUEST["numberOfDotsMin"]);

$base = 10;
$random = mt_rand() / mt_getrandmax();
$numberOfDots = intval(pow($base, log10($minDots) + (log10($maxDots) - log10($minDots)) * $random));
$fileName = exec("sudo python make_image.py " . $numberOfDots);
echo $numberOfDots . ',' . $fileName;
?>
