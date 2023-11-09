<?php
namespace MVC;

class Router
{
    /**
     * @var array Arreglo que almacena las rutas GET y sus funciones asociadas.
     */
    public $rutasGet = [];

    /**
     * @var array Arreglo que almacena las rutas POST y sus funciones asociadas.
     */
    public $rutasPOST = [];

    /**
     * Registra una ruta GET con su función asociada.
     *
     * @param string $url Ruta a ser registrada.
     * @param callable $funcion Función asociada a la ruta.
     * @return void
     */
    public function get($url, $funcion)
    {
        $this->rutasGet[$url] = $funcion;
    }

    /**
     * Registra una ruta POST con su función asociada.
     *
     * @param string $url Ruta a ser registrada.
     * @param callable $funcion Función asociada a la ruta.
     * @return void
     */
    public function post($url, $funcion)
    {
        $this->rutasPOST[$url] = $funcion;
    }

    /**
     * Comprueba las rutas y ejecuta la función asociada a la ruta actual.
     *
     * @return void
     */
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
            call_user_func($funcion, $this); 
        }else{
            echo "Página no encontrada";
        }
    }

    /**
     * Renderiza una vista con datos asociados.
     *
     * @param string $view Nombre de la vista a ser renderizada.
     * @param array $datos Arreglo asociativo de datos para la vista.
     * @return void
     */
    public function render($view, $datos = [])
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