<?php
require "../core/db.php";

$now = time();

$stm = $DB->prepare("
UPDATE users
SET package='free', expiry=0
WHERE expiry > 0 AND expiry < :now
");

$stm->execute([":now" => $now]);

echo "Expired subscriptions cleared\n";
