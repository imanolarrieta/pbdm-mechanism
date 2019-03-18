<?php
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$key = '';
for ($i = 0; $i < 10; $i++) {
    $key .= $characters[rand(0, strlen($characters) - 1)];
}

$unqoutedKey = $key;
$key = "'" . $key . "'";

$db = new SQLite3("batches.db");
$amazonId = "'" . $db->escapeString($_REQUEST["amazonId"]) . "'";
$userIp = "'" . $db->escapeString($_REQUEST["user"]) . "'";
$batch = $db->escapeString($_REQUEST["batch"]);
$score = $db->escapeString($_REQUEST["points"]);

$data = implode(',', array($userIp, $amazonId, $score, $key));
$query = "INSERT INTO " . $batch . "_users" . " (user_ip, amazon_id, score, key) VALUES (" . $data . ");";
$sqlStatement = $db->prepare($query);
$sqlStatement->execute();
$db->close();
echo $unqoutedKey;
?>