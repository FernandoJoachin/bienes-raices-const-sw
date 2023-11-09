<?php

namespace Modelo;

class Articulo extends ActiveRecord
{
    protected static $columnasDB = ["id", "autor", "fecha", "titulo", "descripcion", "contenido", "imagen"];
    protected static $nombreTabla = "blog";

    public  $id;
    public $autor;
    public $fecha;
    public $titulo;
    public $descripcion;
    public $contenido;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->autor = $args["autor"] ?? "";
        $this->fecha = date("Y/m/d");
        $this->titulo = $args["titulo"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->contenido = $args["contenido"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
    }
    public function validar()
    {
        if (!$this->autor) {
            self::$errores[] = "Debes agregar un autor";
        }

        if (!$this->titulo) {
            self::$errores[] = "Debes agregar un titulo";
        }

        if (!$this->descripcion) {
            self::$errores[] = "Necesitas agregar una descripcion";
        } else if (strlen($this->descripcion) < 20) {
            self::$errores[] = "La descripcion debe tener al menos 20 caracteres";
        } else if (strlen($this->descripcion) > 200) {
            self::$errores[] = "La descripcion no debe exceder los 200 caracteres";
        }

        if (!$this->contenido) {
            self::$errores[] = "El contenido es obligatorio";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
}
