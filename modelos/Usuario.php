<?php
namespace Modelo;

use Modelo\ActiveRecord;

class Usuario extends ActiveRecord
{
    /**
     * @var array Lista de atributos de la tabla en la base de datos.
     */
    protected static $atributosTablaEnBD = ["id", "email", "password"];

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $nombreTablaEnBD = "usuarios";

    /**
     * @var int|null Identificador único del usuario.
     */
    public $id;

    /**
     * @var string Dirección de correo electrónico del usuario.
     */
    public $email;

    /**
     * @var string Contraseña del usuario.
     */
    public $password;

    /**
     * Constructor de la clase Usuario.
     *
     * @param array $args Argumentos para inicializar el objeto Usuario.
     */
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
    }

    /**
     * Valida los atributos del Usuario y devuelve los errores encontrados.
     *
     * @return array Errores de validación.
     */
    public function validarErrores()
    {
        if (!$this->email) {
            self::$errores[] = "El email es obligatorio.";
        }

        if (!$this->password) {
            self::$errores[] = "El password es obligatorio.";
        }

        return self::$errores;
    }

    /**
     * Comprueba si el usuario existe en la base de datos.
     *
     * @return mixed Resultado de la consulta o falso si el usuario no existe.
     */
    public function comprobarUsuario()
    {
        $query = "SELECT * FROM " . self::$nombreTablaEnBD . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if (!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe.";
            return false;
        }
        return $resultado;
    }

    /**
     * Comprueba si la contraseña proporcionada coincide con la almacenada en la base de datos.
     *
     * @param mixed $resultado Resultado de la consulta que contiene la información del usuario.
     * @return bool Verdadero si la contraseña es correcta, falso en caso contrario.
     */
    public function comprobarContraseña($existeUsuarioBD)
    {
        $usuario = $existeUsuarioBD->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);
        if (!$autenticado) {
            self::$errores[] = "El password es incorrecto.";
        }
        return $autenticado;
    }

    /**
     * Autentica al usuario y establece las variables de sesión.
     *
     * @return void
     */
    public function autenticarUsuario()
    {
        $_SESSION["usuario"] = $this->email;
        $_SESSION["login"] = true;
        header("Location: /admin");
        exit;
    }
}