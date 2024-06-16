<?php
namespace Controllers;
use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
     public static function login(Router $router) {

      $alertas = [];
     

     if($_SERVER["REQUEST_METHOD"] === "POST"){
      $auth = new Usuario($_POST);
       
      $alertas = $auth->validarLogin();
      if(empty($alertas)){
         //Comprobar que exista el usuario

         $usuario = Usuario::where("email", $auth->email);
         
         if($usuario){
            //Verificar el password
            if( $usuario->comprobarPasswordAndVerificado($auth->password)){
               // Autenticar el Usuario
               session_start();

               $_SESSION["id"] = $usuario->id;
               $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
               $_SESSION["email"] = $usuario->email;
               $_SESSION["login"] = true;

                // Redireccionamiento 

                if($usuario->admin === "1"){
                  $_SESSION["admin"] = $usuario->admin ?? null;
                  header("location: /admin");
                }else{
                  header("location: /cita");
                }
            
            }
           
         } else {
            Usuario::setAlerta("error", "Usuario No Encontrado");
         }
         
      }
  
     }
      
     $alertas = Usuario::getAlertas();

      $router->render('auth/login', [
         "alertas" => $alertas
      ]);

     }
     public static function logout(){
        session_start();

        $_SESSION = [];

        header("Location: /");

     }
     public static function olvide(Router $router){

      $alertas = [];

      if($_SERVER["REQUEST_METHOD"] === "POST"){
         $auth = new Usuario($_POST);
         $alertas = $auth->validarEmail();
          
         if(empty($alertas)){
            $usuario = Usuario::where("email", $auth->email);

           if($usuario && $usuario->confirmado === "1"){

           //Generar un Token
           $usuario->crearToken();
           $usuario->guardar();

           //Enviar el Email
           $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
           $email->enviarInstrucciones();


           //Alerta de Exito
           Usuario::setAlerta("exito", "Revista tu Bandeja de Entrada");
           
           }else{
            Usuario::setAlerta("error", "El Usuario no existe o no está confirmado");
           }

         }
      } 
      $alertas = Usuario::getAlertas();

      $router->render("auth/olvide-password",[
         "alertas" => $alertas
      ]);
     }
     public static function recuperar(Router $router){

      $alertas = [];
      $error = false;
      $token = s($_GET["token"]);
      
      //Buscar usuario ´por token

      $usuario = Usuario::where("token", $token);

      if(empty($usuario)){
         Usuario::setAlerta("error", "token no Válido");
         $error = true;
      }
      
     //Leer el nuevo password y guardarlo
     if($_SERVER["REQUEST_METHOD"] === "POST"){
        $password = new Usuario($_POST);
        $alertas = $password->validarPassword();
      if(empty($alertas)){
         $usuario->password = null;
         $usuario->password = $password->password;
         $usuario->hashPassword();
         $usuario->token = null;

         $resultado = $usuario->guardar();
         if($resultado){
            header("Location: /");
         }

       
      }
     }


      $alertas = Usuario::getAlertas();

        $router->render("auth/recuperar-password", [ "alertas" => $alertas, "error" => $error]);
     }
     public static function crear(Router $router){
      $usuario = new Usuario;

      // Alertas Vacias
      $alertas = [];
      if($_SERVER["REQUEST_METHOD"] === "POST"){

       $usuario->sincronizar($_POST);
       $alertas = $usuario->validarNuevaCuenta();

      //Revisar que alerta este vacio
       if(empty($alertas)){
          //Verificar que el usuario no esté registrado
         $resultado = $usuario->existeUsuario();

         if($resultado->num_rows){
            $alertas = Usuario::getAlertas(); 
         }else{
            //Hashear el password
            $usuario->hashPassword();

            //Generar Token Unico
            $usuario->crearToken();


            //Enviar el Email
            $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
            $email->enviarConfirmacion();

            $resultado = $usuario->guardar();
              
                if($resultado){
                  header("Location: /mensaje");
                }

            debuguear($usuario);
         }
       }

}

        $router->render("auth/crear-cuenta", [
         "usuario" => $usuario,
         "alertas" => $alertas
        ]);
     }

     public static function mensaje(Router $router){
      $router->render("auth/mensaje");
     }
     public static function confirmar(Router $router){
     $alertas = [];
     $token = s($_GET["token"]);
     $usuario = Usuario::where("token", $token);

     if(empty($usuario)){
      //Mostrar mensaje de error
      Usuario::setAlerta("error", "token no Válido");
     } else{
      //Modificar a ususario Confirmado
      $usuario->confirmado = "1";
      $usuario->token = null;
      $usuario->guardar();
      Usuario::setAlerta("exito", "Cuenta Comprobada Correctamente");
     }
      //Obtener Alertas
      $alertas = Usuario::getAlertas();
      //Renderizar Vista
      $router->render("auth/confirmar-cuenta", ["alertas" => $alertas]);
     }

}