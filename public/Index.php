require "../core/db.php";
$DB->exec(file_get_contents("../migrations/schema.sql"));


<?php
echo "Railway PHP OK";
