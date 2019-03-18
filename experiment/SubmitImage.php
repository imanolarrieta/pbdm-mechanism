<?php
$db = new SQLite3("batches.db");
$batch = $db->escapeString($_REQUEST["batch"]);
$user_ip = "'" . $db->escapeString($_REQUEST["user"]) . "'";
$guess = $db->escapeString($_REQUEST["guess"]);
$answer = $db->escapeString($_REQUEST["answer"]);
$time = $db->escapeString($_REQUEST["time"]);
$index = $db->escapeString($_REQUEST["index"]);

$data = implode(',', array($user_ip, $index, $time, $guess, $answer));
$query = "INSERT INTO " . $batch . " (user_ip, image_index, time, guess, answer) VALUES (" . $data . ");";
$sqlStatement = $db->prepare($query);
$sqlStatement->execute();
$db->close();
echo $query;
?>