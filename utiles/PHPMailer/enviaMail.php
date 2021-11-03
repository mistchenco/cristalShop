<?php
// include_once '../estructura/cabecera.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

/**
 * Creamos la clase enviarMail para que pueda ser utilizada en distintos momentos dependendiento de la implementacion
 */
class enviarMail{
 
    private $mail;
    private $host;
    private $SMTPAuth;
    private $Username;
    private $Password;
    private $SMTPSecure;
    private $Port;

    private $mailFrom;
    private $mailSender;
    function __construct(){
        $this->mail       = new PHPMailer(true);// Se crea la clase PHPMailer
        $this->host       ="smtp.gmail.com"; //Configura el servidor smtp para enviar mail
        $this->SMTPAuth   =true; //Habilita la autenticacion smtp
        $this->Username   ="programacionweb73@gmail.com"; //Cuenta por la que se envia email
        $this->Password   ="fai38493294"; //pass de la cuenta
        $this->SMTPSecure ="TLS"; //El protocolo TLS (Transport Layer Security, seguridad de la capa de transporte)  
        $this->Port       =587;// Puerto de salifa
        
        $this->mailFrom   ="programacionweb73@gmail.com"; //Quien envia el correo
        $this->mailSender ="Administracion de Sistemas";// a nombre de 
    }

    public function newEmail($mailFrom="", $mailSender="",  $mailFor="", $mailRecipientName="", $mailSubject="", $mailBody="")
    {
        try {
            //Server settings
            $this->mail->SMTPDebug = false; //Da informacion en caso de no poder conectar al smtp
            $this->mail->isSMTP();  //Envio mediante servidor SMTP
            $this->mail->Host       = $this->host;
            $this->mail->SMTPAuth   = $this->SMTPAuth;
            $this->mail->Username   = $this->Username;
            $this->mail->Password   = $this->Password;
            $this->mail->SMTPSecure = $this->SMTPSecure;
            $this->mail->Port       = $this->Port;

            //Recipients
            $mailFrom =($mailFrom=="" || empty($mailFrom))?$this->mailFrom:$mailFrom;
            $mailSender =($mailSender=="" || empty($mailSender))?$this->mailSender:$mailSender;

            $this->mail->setFrom($mailFrom, $mailSender);
            $this->mail->addAddress($mailFor, $mailRecipientName);     // Add a recipient
            $this->mail->addReplyTo($mailFrom, $mailSender);
       

            // Content
            $this->mail->isHTML(true); // Enviamos en formato html
            $this->mail->Subject = $mailSubject; // El Asunto del Mail
            $this->mail->Body    = $mailBody; //Contenido del Mail
            $this->mail->AltBody = 'Su gestor de correos no soporta HTML.';//Se envia en caso de que el cliente no soporte html

            $this->mail->send(); //Funcion que envia mail
            return true;
        } catch (Exception $e) {
            return "Ocurrió un error al enviar el correo: {$this->mail->ErrorInfo}";
        }
    }
}