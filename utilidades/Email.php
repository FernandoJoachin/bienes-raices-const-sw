<?php

namespace Utilidades;

class Email {

    private $respuestasFormulario;
    
    public function __construct($respuestaSolicitada)
    {
        $this->respuestasFormulario = $_POST[$respuestaSolicitada]; 
    }

    public function enviarCorreoContacto() {

        include __DIR__ . "/../includes/template/credenciales_correo.php";

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
            $mensajeResultado = "El mensaje se envio correctamente";
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
}