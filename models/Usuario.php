<?php

namespace Model;

class Usuario extends ActiveRecord{
    //base de datos
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "apellido", "email", "password", "telefono", "admin", "confirmado", "token"];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){

        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->admin = $args["admin"] ?? "0";
        $this->confirmado = $args["confirmado"] ?? "0";
        $this->token = $args["token"] ?? "";
    }

       //Mensajes de validación para crear la cuenta
     public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas["error"][] = "El nombre del cliente es Obligatorio";
        }

        if(!$this->apellido){
            self::$alertas["error"][] = "El apellido del cliente es Obligatorio";
        }

        if(!$this->email){
            self::$alertas["error"][] = "El Email del cliente es Obligatorio";
        }

        if(!$this->password){
            self::$alertas["error"][] = "La contraseña es Obligatoria";
        }
        if(strlen($this->password) < 6){
            self::$alertas["error"][] = "La contraseña debe contener minimo 6 caracteres";

        }

        return self::$alertas;
     }
    
     public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][] = "El Email Es Obligatorio";
        }
        if(!$this->password){
            self::$alertas["error"][] = "El Password Es Obligatorio";
        }

        return self::$alertas;
     }

     public function validarEmail(){
        if(!$this->email){
            self::$alertas["error"][] = "El Email Es Obligatorio";
        }
        return self::$alertas;
     }

     public function validarPassword(){
        if(!$this->password){
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }
         if(strlen($this->password) < 8){
            self::$alertas["error"][] = "La contraseña debe tener al menos 8 caracteres";
         }

         return self::$alertas;
     }
     //Revisa si el usuario ya existe
 public function existeUsuario(){
    $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

    
    $resultado = self::$db->query($query);

    if($resultado->num_rows){
        self::$alertas["error"][] = "El Usuario ya está registrado";
    }

    return $resultado;
 }

 public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
 }

 public function crearToken(){
    $this->token = uniqid();
 }

 public function comprobarPasswordAndVerificado($password){
    $resultado = password_verify($password, $this->password);
    if(!$resultado || !$this->confirmado){
        self::$alertas["error"][] = "Contraseña Incorrecta o tu cuenta no ha sido Confirmada";
    } else{
       return true;
    }
 }

}