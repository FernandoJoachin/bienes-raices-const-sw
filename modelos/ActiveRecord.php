<?php
namespace Modelo;

class ActiveRecord
{
/**
     * @var mixed Instancia de la conexión a la base de datos.
     */
    protected static $db;

    /**
     * @var array Lista de atributos de la tabla en la base de datos.
     */
    protected static $atributosTablaEnBD = [];

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $nombreTablaEnBD = "";

    /**
     * @var array Lista de errores generados durante la ejecución.
     */
    protected static $errores = [];

    /**
     * Obtiene todos los registros de la tabla en la base de datos.
     *
     * @return array Lista de objetos correspondientes a los registros.
     */
    public static function obtenerTodosRegistrosEnBD()
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD;

        return self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
    }

    /**
     * Encuentra un registro por su identificador único.
     *
     * @param int $id Identificador único del registro.
     * @return mixed Objeto correspondiente al registro encontrado.
     */
    public static function encontrarRegistroPorId($id)
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " WHERE id={$id}";
        $registros = self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
        return array_shift($registros);
    }

    /**
     * Encuentra un registro por su correo.
     *
     * @param int $id Identificador único del registro.
     * @return mixed Objeto correspondiente al registro encontrado.
     */
    public static function encontrarRegistroPorEmail($columna, $valor) 
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " WHERE $columna = '$valor'";
        $resultado = self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
        return array_shift( $resultado ) ;
    }

    /**
     * Obtiene una cantidad específica de registros.
     *
     * @param int $cantidad Cantidad de registros a obtener.
     * @return array Lista de objetos correspondientes a los registros.
     */
    public static function obtenerRegistrosConLimite($cantidad)
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " LIMIT " . $cantidad;

        return self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
    }

    /**
     * Crea o actualiza un registro en la base de datos.
     *
     * @return void
     */
    public function almacenarEnBD()
    {
        if (!is_null($this->id)) {
            return $this->actualizarEnBD();
        } else {
            return $this->crearEnBD();
        }
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @return void
     */
    public function actualizarEnBD()
    {
        $atributosFiltrados = $this->filtrarAtributosParaConsultaBD();
        $valores = [];
        foreach ($atributosFiltrados as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $setInfo = join(", ", $valores);
        $instruccionDeConsultaBD = "UPDATE " . static::$nombreTablaEnBD . " SET {$setInfo}";
        $instruccionDeConsultaBD .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
        $instruccionDeConsultaBD .= " LIMIT 1";
        $resultado = self::$db->query($instruccionDeConsultaBD);

        return $resultado;
    }

    /**
     * Crea un nuevo registro en la base de datos.
     *
     * @return void
     */
    public function crearEnBD()
    {
        $atributosFiltrados = $this->filtrarAtributosParaConsultaBD();

        $clavesAtributosFiltrados = join(", ", array_keys($atributosFiltrados));
        $valoresAtributosFiltrados = join("', '", array_values($atributosFiltrados));

        $instruccionDeConsultaBD = "INSERT INTO " . static::$nombreTablaEnBD .
        " ({$clavesAtributosFiltrados}) VALUES ('{$valoresAtributosFiltrados}')";
        $resultadoConsultaBD = self::$db->query($instruccionDeConsultaBD);

        return $resultadoConsultaBD;
    }

    /**
     * Borra un registro de la base de datos.
     *
     * @param string $tipo Tipo de registro a borrar (opcional).
     * @return void
     */
    public function borrarRegistroBD()
    {
        $instruccionDeConsultaBD = "DELETE FROM " . static::$nombreTablaEnBD .
        " WHERE id="  . self::$db->escape_string($this->id) .
        " LIMIT 1";

        $resultado = self::$db->query($instruccionDeConsultaBD);

        return $resultado;
    }

    // Obtener el total de registros
    public static function total($columna = "", $valor = ""){
        $query = "SELECT COUNT(*) FROM " . static::$nombreTablaEnBD;
        if($columna){
            $query .= " WHERE {$columna} = {$valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    public static function paginar($por_pagina, $offset){
        $query = "SELECT * FROM " . static::$nombreTablaEnBD . " ORDER BY id DESC LIMIT {$por_pagina} OFFSET {$offset}" ;
        $resultado = self::obtenerRegistrosConConsulta($query);
        return $resultado;
    }
    

    /**
     * Busca un registro en la base de datos por el valor de una columna específica.
     *
     * @param string $columna Nombre de la columna por la cual realizar la búsqueda.
     * @param mixed $valor Valor que se debe buscar en la columna.
     * @return array El primer registro encontrado.
     */
    public static function buscarPorColumna($columna, $valor) {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " WHERE {$columna} = '{$valor}'";
        $resultadoConsultaBD = self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
        return array_shift( $resultadoConsultaBD ) ;
    }

    /**
     * Filtra los atributos del objeto para su uso en consultas a la base de datos.
     *
     * @return array Atributos filtrados.
     */
    public function filtrarAtributosParaConsultaBD()
    {
        $atributosMenosId = $this->obtenerAtributosMenosId();

        $sanitizar = [];
        foreach ($atributosMenosId as $key => $value) {
            $sanitizar[$key] = self::$db->escape_string($value); 
        }

        return $sanitizar;
    }

    /**
     * Devuelve los atributos del objeto, excluyendo el atributo "id".
     *
     * @return array Atributos del objeto sin incluir "id".
     */
    private function obtenerAtributosMenosId()
    {
        $atributosSinId = [];
        foreach (static::$atributosTablaEnBD as $atributo) {
            if ($atributo === "id") {
                continue;
            }
            $atributosSinId[$atributo] = $this->$atributo;
        }

        return $atributosSinId;
    }

    /**
     * Devuelve los errores de validación del modelo.
     *
     * @return void
     */
    public function validarErrores()
    {
        static::$errores = [];

        return static::$errores;
    }

    /**
     * Establece la conexión a la base de datos.
     *
     * @param mixed $database Instancia de la base de datos.
     * @return void
     */
    public static function establecerBD($database)
    {
        self::$db = $database;
    }

    /**
     * Obtiene los errores almacenados.
     *
     * @return array Errores almacenados.
     */
    public static function obtenerErrores()
    {
        return static::$errores;
    }

    /**
     * Establece un error personalizado en la clase.
     *
     * @param string $mensaje Mensaje descriptivo del error.
     * @return void
     */
    public static function establecerError($mensaje) {
        static::$errores[] = $mensaje;
    }

    /**
     * Establece la propiedad "imagen" del objeto y borra la imagen anterior si existe, si el objeto ya tiene un ID.
     *
     * @param string $imagen Nombre del archivo de imagen.
     * @return void
     */
    public function establecerImagen($imagen)
    {
        if (!is_null($this->id)) {
            $this->borrarArchivoImagen();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    /**
     * Borra el archivo de imagen asociado al objeto si existe.
     *
     * @return void
     */
    public function borrarArchivoImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMG . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMG . $this->imagen);
        }
    }

    /**
     * Realiza una consulta a la base de datos y devuelve los resultados de la consulta.
     *
     * @param string $instruccionDeConsultaBD Consulta SQL.
     * @return array Array de objetos basados en los resultados de la consulta.
     */
    private static function obtenerRegistrosConConsulta($instruccionDeConsultaBD)
    {
        $resultadoQueryBD = self::$db->query($instruccionDeConsultaBD);

        $objetosResultantesDelQuery = [];
        while ($registro = $resultadoQueryBD->fetch_assoc()) {
            $objetosResultantesDelQuery[] = static::crearObjetoPorRegistro($registro);
        }
        $resultadoQueryBD->free();

        return $objetosResultantesDelQuery;
    }

    /**
     * Crea un objeto basado en un registro de la base de datos.
     *
     * @param array $registro Registro de la base de datos.
     * @return mixed Objeto basado en el registro.
     */
    private static function crearObjetoPorRegistro($registro)
    {
        $objetoPorRegistro = new static();
        foreach ($registro as $key => $value) {
            if (property_exists($objetoPorRegistro, $key)) {
                $objetoPorRegistro->$key = $value;
            }
        }
        return $objetoPorRegistro;
    }

    /**
     * Sincroniza los cambios en el objeto utilizando los argumentos proporcionados.
     *
     * @param array $args Argumentos para sincronizar cambios en el objeto.
     * @return void
     */
    public function sincronizarCambiosConObjeto($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this,$key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}