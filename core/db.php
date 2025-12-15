<?php

$dsn = sprintf(
    "pgsql:host=%s;port=%s;dbname=%s",
    $_ENV['PGHOST'],
    $_ENV['PGPORT'],
    $_ENV['PGDATABASE']
);

try {
    $DB = new PDO($dsn, $_ENV['PGUSER'], $_ENV['PGPASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed");
}
