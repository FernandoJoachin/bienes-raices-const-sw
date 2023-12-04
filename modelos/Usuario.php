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
     * @var bool Indica el estado de confirmación del usuario: 1 si está confirmado, 0 si no está confirmado.
     */
    public $estaConfirmado;

    /**
     * @var string Token de confirmación.
     */
    public $token;

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
        $this->estaConfirmado = $args["estaConfirmado"] ?? false;
        $this->token = $args["token"] ?? "";
    }

    /**
     * Valida los atributos del Usuario y devuelve los errores encontrados.
     *
     * @return array Errores de validación.
     */
    public function validarErrores()
    {
        self::$errores = [];
        
        $this->validarEmail();
        $this->validarPassword();

        return self::$errores;
    }

    /**
     * Valida la dirección de correo electrónico.
     *
     * @return void.
     */
    public function validarEmail() {
        self::$errores = [];

        if(!$this->email) {
            self::$errores[] = 'El email es obligatorio.';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores[] = 'Email no válido';
        }
    }

    /**
     * Valida la contraseña del usuario.
     *
     * @return void.
     */
    public function validarPassword() {
        self::$errores = [];

        if(!$this->password) {
            self::$errores[] = 'El password es obligatorio.';
        }else if(strlen($this->password) < 6) {
            self::$errores[] = 'El password debe contener al menos 6 caracteres.';
        }
    }

    /**
     * Valida si en los campos de "contraseña" y "confirmar contraseña" fueron
     * puestos los mismos valores.
     *
     * @return void Errores de validación.
     */
    public function validarConfirmacionDeContraseña($contraseñaConfirmada)
    {
        if ($this->password !== $contraseñaConfirmada) {
            self::$errores[] = "Las contraseñas deben ser iguales.";
        }
    }
    
    /**
     * Hace el Hash de la contraseña del usuario para guardarla en la base 
     * de datos.
     *
     * @return void
     */
    public function hashearContraseña(){
        $this->password =  password_hash($this->password, PASSWORD_BCRYPT);
    }

    /**
     * Valida el correo ingresado por el usuario y devuelve los errores.
     *
     * @return array Errores de validación.
     */
    public function validarCorreo() {
        if(!$this->email) {
            self::$errores['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['error'][] = 'Email no válido';
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
        header("Location: /admin-inicio");
        exit;
    }

    /**
     * Genera un token único y lo asigna a la propiedad $token de la instancia actual.
     *
     * @return void
     */
    public function crearToken() {
        $this->token = uniqid();
    }
}