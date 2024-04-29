<?php

namespace App;

class Propiedad {

    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'parking', 'creado', 'vendedores_id'];

    //Errores/validaciones
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $parking;
    public $creado;
    public $vendedores_id;

    //Definir la conexion a la base de datos
    public static function setDB ($database) {
        self::$db = $database;
    }

    public function __construct($args = []) {
        $this -> id = $args['id'] ?? '';
        $this -> titulo = $args['titulo'] ?? '';
        $this -> precio = $args['precio'] ?? '';
        $this -> imagen = $args['imagen'] ?? '';
        $this -> descripcion = $args['descripcion'] ?? '';
        $this -> habitaciones = $args['habitaciones'] ?? '';
        $this -> wc = $args['wc'] ?? '';
        $this -> parking = $args['parking'] ?? '';
        $this -> creado = date('Y/m/d');
        $this -> vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar() {

        //Validacion para las variables, evitar inyecciones SQL, etc
        $atributos = $this->sanitizarAtributos();

        //Insertar en la DB
        $query = "INSERT INTO propiedades (";
        $query .= join (', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join ("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    //Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen) {
        //Asignar al atributo imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Validacion
    public static function getErrores() {
        return self::$errores;
    }

    public function validar(){
        if (!$this ->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this ->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
    
        if (strlen($this ->descripcion) < 50) {
            self::$errores[] = "La descripción es obligatoria y tiene que contener al menos 50 caracteres";
        }
    
        if (!$this ->habitaciones) {
            self::$errores[] = "Debes añadir el numero de habitaciones";
        }
    
        if (!$this ->wc) {
            self::$errores[] = "Debes añadir el numero de baños";
        }
    
        if (!$this ->parking) {
            self::$errores[] = "Debes añadir el numero de parking";
        }
    
        if (!$this ->vendedores_id) {
            self::$errores[] = "Debes elegir el vendedor";
        }
    
        if (!$this ->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        
        return self::$errores;
    }

}