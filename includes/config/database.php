<?php
function conectarDB() : mysqli{
    $db = mysqli_connect(
        $_ENV['DB_HOST'] ?? 'localhost',
        $_ENV['DB_USER'] ?? 'carlos-may', 
        $_ENV['DB_PASS'] ?? '12345678', 
        $_ENV['DB_NAME'] ?? 'carlos_may_db'
    );

    $db->set_charset("utf8");

    if (!$db) {
        echo "Error: No se pudo conectar a MySQL.";
        echo "errno de depuración: " . mysqli_connect_errno();
        echo "error de depuración: " . mysqli_connect_error();
        exit;
    }

    return $db;
}