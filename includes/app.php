<?php
use Dotenv\Dotenv;
use Modelo\ActiveRecord;
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once "funciones.php";
require_once "config/database.php";

$db = conectarDB();
ActiveRecord::establecerBD($db);