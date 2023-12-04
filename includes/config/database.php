<?php

include_once __DIR__ . "/config.inc.php";

function conectarDB() : mysqli{
    $db = new mysqli($GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["contrasena"], $GLOBALS["base_datos"]);
    mysqli_set_charset($db, "utf8");
    if(!$db){
        echo "No se pudo conectar";
        exit;
    }

    return $db;
}