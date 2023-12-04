<?php

namespace Utilidades;

class Email {

    private $respuestasFormulario;
    
    public function __construct($respuestaSolicitada)
    {
        $this->respuestasFormulario = $_POST[$respuestaSolicitada]; 
    }

    public function enviarCorreoContacto() {

        include_once __DIR__ . "/../includes/template/credenciales_correo.php";

        $contenidoCorreo = "<html>";
        $contenidoCorreo .= "<p>Tienes un nuevo mensaje </p>";
        $contenidoCorreo .= "<p>Nombre: ". $this->respuestasFormulario["nombre"] . " </p>";
        $contenidoCorreo .= "<p>Mensaje: ". $this->respuestasFormulario["mensaje"] . " </p>";

        $contenidoCorreo .= "<p>Compra o Vende: ". $this->respuestasFormulario["tipo"] . " </p>";
        $contenidoCorreo .= "<p>Presupuesto o Precio: $". $this->respuestasFormulario["precio"] . " </p>";

        if($this->respuestasFormulario["contacto"] === "telefono"){
            $contenidoCorreo .= "<p>Eligio ser contactado por teléfono:</p>";
            $contenidoCorreo .= "<p>Telefono: ". $this->respuestasFormulario["telefono"] . " </p>";
            $contenidoCorreo .= "<p>Fecha de contacto: ". $this->respuestasFormulario["fecha"] . " </p>";
            $contenidoCorreo .= "<p>Hora: ". $this->respuestasFormulario["hora"] . " </p>";
        }else{
            $contenidoCorreo .= "<p>Eligió ser contactado por email:</p>";
            $contenidoCorreo .= "<p>Email: ". $this->respuestasFormulario["email"] . " </p>";
        }
        $contenidoCorreo .= "</html>";
        $mail->Subject = "Mensaje del formulario de contacto";
        $mail->Body = $contenidoCorreo;
        
        if( $mail->send()){
            $enviado = true;
            $mensajeResultado = "El mensaje se envió correctamente";
        }else{
            $enviado = false;
            $mensajeResultado = "Sucedió un error, el mensaje no se pudo enviar";
        }

        $_SESSION["respuesta"] = [
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado
        ];

        return $enviado;
    }

    public function enviarCorreoReestablecerContraseña($token) {

        include_once __DIR__ . "/../includes/template/credenciales_correo.php";

        $contenido = '<html>';
        $contenido .= "<p>Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/restablecer-contraseña?token=" . $token . "'>Reestablecer Contraseña</a></p>";        
        $contenido .= "<p>Si no solicitaste este cambio, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';
        $mail->Body = $contenido;

        $mail->Subject = "Recupera tu contraseña";
        $mail->Body = $contenido;
        
        if( $mail->send()){
            $enviado = true;
            $mensajeResultado = "El mensaje se envió correctamente, revise su bandeja de entrada";
        }else{
            $enviado = false;
            $mensajeResultado = "Sucedió un error, el mensaje no se pudo enviar";
        }

        $_SESSION["respuesta"] = [
            "mensajeResultado" => $mensajeResultado,
            "enviado" => $enviado,
            "correcto" => true
        ];

        return $enviado;
    }
}