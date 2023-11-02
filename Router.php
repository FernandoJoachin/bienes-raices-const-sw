<?php
namespace MVC;

class Router
{
    public $rutasGet = [];
    public $rutasPOST = [];

    public function get($url, $funcion)
    {
        $this->rutasGet[$url] = $funcion;
    }

    public function post($url, $funcion)
    {
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas()
    {
        session_start();
        $urlActual = $_SERVER["PATH_INFO"] ?? "/";
        $metodoHTTP = $_SERVER["REQUEST_METHOD"];

        if($metodoHTTP === "GET"){
            $funcion = $this->rutasGet[$urlActual] ?? null;
        }else{
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        if($funcion){
            call_user_func($funcion,$this); 
        }else{
            echo "Pagina no encontrada";
        }
    }

    public function render($view, $datos=[])
    {
        foreach($datos as $key => $value){
            $$key = $value;
        }
        ob_start();
        include __DIR__ . "/vistas/{$view}.php";
        $contenido = ob_get_clean();
        include __DIR__ . "/vistas/layout.php";
    }
}