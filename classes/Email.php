<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

public $email;
public $nombre;
public $token;


    public function __construct($email, $nombre, $token){
     
     
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = '2525';
        $mail->Username = 'd14cad08d02c2c';
        $mail->Password = '36947dd19d95e8';
       $mail->setFrom("odontologicoyolimarduerto@gmail.com"); //Quien envia
       $mail->addAddress("cesjhoandejesus@gmail.com", ""); //Quien Recibe
       $mail->Subject = "Confirma tu cuenta";

       //Haciendo HTML
       $mail->isHTML(TRUE);
       $mail->CharSet = "UTF-8";

       $contenido = "<html>";
       $contenido .= "<p><strong>Hola " . $this->email . "</strong> 
       Has creado tu cuenta en el consultorio odontologico Dr. Yolimar Duerto, Solo debes confirmar tu cuenta con el siguiente enlace;</p>";
       $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";   
       $contenido .= "<p>Si tu no solicitaste este cambio puedes ignorar el mensaje</p>";
       $contenido .= "</html>";

       $mail->Body = $contenido;

       //Enviar Email

       $mail->send();
       
       

    }
   public function enviarInstrucciones(){
    $URLWEB = 'https://localhost:3000'; //Cambiamos el HOST LOCAL
    $mail = new PHPMailer();
        $mail->isSMTP();
       $mail->Host = 'sandbox.smtp.mailtrap.io';
       $mail->SMTPAuth = true;
       $mail->Port = '2525';
       $mail->Username = 'd14cad08d02c2c';
       $mail->Password = '36947dd19d95e8';

   
   $mail->setFrom("cesjhoandejesus@gmail.com"); //Quien envia
   $mail->addAddress("cesjhoandejesus@gmail.com", ""); //Quien Recibe
   $mail->Subject = "Reestablece tu Contraseña";

   //Haciendo HTML
   $mail->isHTML(TRUE);
   $mail->CharSet = "UTF-8";

   $contenido = "<html>";
   $contenido .= "<p><strong>Hola " . $this->email . "</strong> 
   Has solicitado tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
   $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Password</a>";        
   $contenido .= "<p>Si tu no solicitaste este cambio puedes ignorar el mensaje</p>";
   $contenido .= "</html>";

   $mail->Body = $contenido;

   //Enviar Email

   $mail->send();
   
   }
}