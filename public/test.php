<?php


$start = microtime(true);
$mysqli = new mysqli("147.93.105.43", "th777gkf1-dev", "th777gkf1-dev", "th777gkf1-dev");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$end = microtime(true);
echo "Connection took: " . ($end - $start) . " seconds";
$mysqli->close();

?>