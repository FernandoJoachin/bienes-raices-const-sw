<?php
require_once "funciones.php";
require_once "config/database.php";
require_once __DIR__ . "/../vendor/autoload.php";
use Modelo\ActiveRecord;
$db = conectarDB();
ActiveRecord::establecerBD($db);