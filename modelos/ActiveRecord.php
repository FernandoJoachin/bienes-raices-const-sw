<?php
namespace Modelo;

class ActiveRecord
{
    protected static $db;
    protected static $atributosTablaEnBD = [];
    protected static $nombreTablaEnBD = "";
    protected static $errores = [];

    public static function obtenerTodosRegistrosEnBD()
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD;

        return self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
    }

    public static function encontrarRegistroPorId($id)
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " WHERE id={$id}";
        $registros = self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
        debuguear($registros);
        return array_shift($registros);
    }

    public static function obtenerRegistrosConLimite($cantidad)
    {
        $instruccionDeConsultaBD = "SELECT * FROM " . static::$nombreTablaEnBD . " LIMIT " . $cantidad;

        return self::obtenerRegistrosConConsulta($instruccionDeConsultaBD);
    }

    public function almacenarEnBD()
    {
        if (!is_null($this->id)) {
            $this->actualizarEnBD();
        } else {
            $this->crearEnBD();
        }
    }

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

        if($resultado){
            header("Location: /admin?resultado=2");
        }
    }

    public function crearEnBD()
    {
        $atributosFiltrados = $this->filtrarAtributosParaConsultaBD();

        $clavesAtributosFiltrados = join(", ", array_keys($atributosFiltrados));
        $valoresAtributosFiltrados = join("', '", array_values($atributosFiltrados));

        $instruccionDeConsultaBD = "INSERT INTO " . static::$nombreTablaEnBD .
        " ({$clavesAtributosFiltrados}) VALUES ('{$valoresAtributosFiltrados}')";
        $resultadoConsultaBD = self::$db->query($instruccionDeConsultaBD);

        if ($resultadoConsultaBD) {
            header("Location: /admin?resultado=1");
        }
    }

    public function borrarRegistroBD(String $tipo = "")
    {
        $instruccionDeConsultaBD = "DELETE FROM " . static::$nombreTablaEnBD .
        " WHERE id="  . self::$db->escape_string($this->id) .
        " LIMIT 1";

        $resultado = self::$db->query($instruccionDeConsultaBD);

        if ($resultado) {
            if ($tipo === "propiedad") {
                $this->borrarArchivoImagen();
            }
            header("Location: /admin?resultado=3");
        }
    }

    public function filtrarAtributosParaConsultaBD()
    {
        $atributosMenosId = $this->obtenerAtributosMenosId();

        $sanitizar = [];
        foreach ($atributosMenosId as $key => $value) {
            $sanitizar[$key] = self::$db->escape_string($value); 
        }

        return $sanitizar;
    }

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

    public function validarErrores()
    {
        static::$errores = [];

        return static::$errores;
    }

    public static function establecerBD($database)
    {
        self::$db = $database;
    }

    public static function obtenerErrores()
    {
        return static::$errores;
    }

    public function establecerImagen($imagen)
    {
        if (!is_null($this->id)) {
            $this->borrarArchivoImagen();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public function borrarArchivoImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMG . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMG . $this->imagen);
        }
    }

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

    public function sincronizarCambiosConObjeto($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this,$key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}