<?php
require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";
use Modelo\ActiveRecord;
$db = conectarDB();
ActiveRecord::establecerBD($db);