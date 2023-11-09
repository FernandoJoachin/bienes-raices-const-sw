<?php
namespace Modelo;

class Propiedad extends ActiveRecord
{
    /**
     * @var array Lista de atributos de la tabla en la base de datos.
     */
    protected static $atributosTablaEnBD = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedores_id"];

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $nombreTablaEnBD = "propiedades";

    /**
     * @var int|null Identificador único de la propiedad.
     */
    public $id;

    /**
     * @var string Título de la propiedad.
     */
    public $titulo;

    /**
     * @var string Precio de la propiedad.
     */
    public $precio;

    /**
     * @var string Ruta de la imagen de la propiedad.
     */
    public $imagen;

    /**
     * @var string Descripción de la propiedad.
     */
    public $descripcion;

    /**
     * @var int Número de habitaciones de la propiedad.
     */
    public $habitaciones;

    /**
     * @var int Número de baños de la propiedad.
     */
    public $wc;

    /**
     * @var int Número de lugares de estacionamiento de la propiedad.
     */
    public $estacionamiento;

    /**
     * @var string Fecha de creación de la propiedad.
     */
    public $creado;

    /**
     * @var int Identificador del vendedor asociado a la propiedad.
     */
    public $vendedores_id;

    /**
     * Constructor de la clase Propiedad.
     *
     * @param array $args Argumentos para inicializar el objeto Propiedad.
     */
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->titulo = $args["titulo"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->habitaciones = $args["habitaciones"] ?? "";
        $this->wc = $args["wc"] ?? "";
        $this->estacionamiento = $args["estacionamiento"] ?? "";
        $this->creado = date("Y/m/d");
        $this->vendedores_id = $args["vendedores_id"] ?? "";
    }

    /**
     * Valida los atributos de la Propiedad y devuelve los errores encontrados.
     *
     * @return array Errores de validación.
     */
    public function validarErrores()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título.";
        }

        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio.";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres.";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio.";
        }

        if (!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio.";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "El número de lugares de estacionamiento es obligatorio.";
        }

        if (!$this->vendedores_id) {
            self::$errores[] = 'Elige un vendedor.';
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria.";
        }

        return self::$errores;
    }
}