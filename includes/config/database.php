<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

function conectDB(): mysqli {
    $db = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

    if (!$db) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    mysqli_set_charset($db, "utf8mb4");
    mysqli_query($db, "SET NAMES 'utf8mb4'");

    return $db;
}
