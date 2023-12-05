<?php
namespace Modelo;

class Vendedor extends ActiveRecord
{
    /**
     * @var array Lista de atributos de la tabla en la base de datos.
     */
    protected static $atributosTablaEnBD = ["id", "nombre", "apellido", "telefono"];

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $nombreTablaEnBD = "vendedores";

    /**
     * @var int|null Identificador único del vendedor.
     */
    public $id;

    /**
     * @var string Nombre del vendedor.
     */
    public $nombre;

    /**
     * @var string Apellido del vendedor.
     */
    public $apellido;

    /**
     * @var string Número de teléfono del vendedor.
     */
    public $telefono;

    /**
     * Constructor de la clase Vendedor.
     *
     * @param array $args Argumentos para inicializar el objeto vendedor.
     */
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
    }

    /**
     * Valida los atributos del vendedor y retorna una lista de errores.
     *
     * @return array Lista de errores de validación.
     */
    public function validarErrores()
    {
        if (!$this->nombre) {
            self::$errores[] = "Es obligatorio añadir un nombre";
        }

        if (!$this->apellido) {
            self::$errores[] = "Es obligatorio añadir un apellido";
        }

        if (!$this->telefono) {
            self::$errores[] = "Es obligatorio añadir un teléfono";
        }

        if (!preg_match("/[0-9]{10}/", $this->telefono)) {
            self::$errores[] = "Formato de teléfono inválido";
        }

        return self::$errores;
    }
}