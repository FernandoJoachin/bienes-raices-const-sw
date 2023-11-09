<?php
define("TEMPLATES_URL", __DIR__ ."/template");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMG", __DIR__ . "/../imagenes/");
function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() 
{
    if(!isset($_SESSION["login"])){
        header("Location: /");
        exit;
    }
}

function debuguear($debug)
{
    echo "<pre>";
    var_dump($debug);
    echo "</pre>";
    exit;
}

//Escapar/Sanitizar del HTML
function limpiarHTML($html)
{
    $limpiado = htmlspecialchars($html);
    return $limpiado;
}

//Validar contenido
function validarTipoContenido($tipo)
{
    $tipos = ["vendedor","propiedad"];
    return in_array($tipo,$tipos);
}

//Mostrar mensaje
function mostrarNotificacion($codigo)
{
    $mensaje = "";
    switch ($codigo) {
        case 1:
            $mensaje = "Creado correctamente";
            break;
        case 2:
            $mensaje = "Actualizado correctamente";
            break;
        case 3:
            $mensaje = "Eliminado correctamente";
            break;
        default:
            $mensaje = false;
            break;
    }
    
    return $mensaje;
}

function validarORedireccionar(String $url)
{
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location: {$url}");
    }

    return $id;
}
