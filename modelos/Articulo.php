<?php
namespace Modelo;

class Articulo extends ActiveRecord
{
    /**
     * @var array Lista de atributos de la tabla en la base de datos.
     */
    protected static $atributosTablaEnBD = ["id", "autor", "fecha", "titulo", "descripcion", "contenido", "imagen"];

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $nombreTablaEnBD = "articulos";

    /**
     * @var int|null Identificador único del artículo.
     */
    public $id;

    /**
     * @var string Nombre del autor del artículo.
     */
    public $autor;

    /**
     * @var string Fecha de publicación del artículo.
     */
    public $fecha;

    /**
     * @var string Título del artículo.
     */
    public $titulo;

    /**
     * @var string Descripción corta del artículo.
     */
    public $descripcion;

    /**
     * @var string Contenido completo del artículo.
     */
    public $contenido;

    /**
     * @var string Ruta de la imagen asociada al artículo.
     */
    public $imagen;

    /**
     * Constructor de la clase Articulo.
     *
     * @param array $args Argumentos para inicializar el objeto Articulo.
     */
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

    /**
     * Valida los atributos del Articulo y devuelve los errores encontrados.
     *
     * @return array Errores de validación.
     */
    public function validarErrores()
    {
        if (!$this->autor) {
            self::$errores[] = "Debes agregar un autor.";
        }

        if (!$this->titulo) {
            self::$errores[] = "Debes agregar un título.";
        }

        if (!$this->descripcion) {
            self::$errores[] = "Necesitas agregar una descripción.";
        } else if (strlen($this->descripcion) < 20) {
            self::$errores[] = "La descripción debe tener al menos 20 caracteres.";
        } else if (strlen($this->descripcion) > 200) {
            self::$errores[] = "La descripción no debe exceder los 200 caracteres.";
        }

        if (!$this->contenido) {
            self::$errores[] = "El contenido es obligatorio.";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria.";
        }

        return self::$errores;
    }
}