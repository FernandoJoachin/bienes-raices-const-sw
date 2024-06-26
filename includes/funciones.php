<?php
define("TEMPLATES_URL", __DIR__ ."/template");
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMG", $_SERVER["DOCUMENT_ROOT"] . "/imagenes/");
function incluirTemplate(string $nombre, bool $inicio = false)
{
    include_once TEMPLATES_URL . "/{$nombre}.php";
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
    $tipos = ["vendedor","propiedad", "articulo"];
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

//Verifica la coincidencia de ruta
function validarPaginaActual($ruta) : bool {
    return str_contains($_SERVER['PATH_INFO'] ?? '/',$ruta) ? true : false;
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

function existeUsuario($usuario)
{
    if(!isset($usuario)) {
        header("Location: /iniciar-sesion");
        exit;
    }
}

function existeToken($token)
{
    if(!isset($token)) {
        header("Location: /iniciar-sesion");
        exit;
    }
}

function esAdmin(){
    if($_SESSION["esAdmin"] == 0){
        header("Location: /admin-inicio");
        exit;
    }
}