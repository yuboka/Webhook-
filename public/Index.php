<?php
require "../core/db.php";
$DB->exec(file_get_contents("../migrations/schema.sql"));

echo "Railway PHP OK";
