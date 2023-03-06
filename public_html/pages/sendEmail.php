<?php

//Iniciamos o nos unimos a la sesión
session_start();
if (!isset($_SESSION["token"]) || $_SESSION["user"]["Rol"] != 0) {//Si la sesión no existe o su rol no es usuario normal
    header("Location: ./logOut.php");
}
//Añado la libreria de funciones
require_once "../../resources/library/functions/funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Si recibe un POST
    $errorInputMail = false;
    //En $email guardaremos el contenido del mail
    $email = filtrarArrayInput("email", ["gmail", "subject", "body"], $errorInputMail);
    
} else {//Si no recibe un POST hacemos logOut ya que la única manera de acceder a esta página es empleando un POST
    header("Location: ./logOut.php");
}

//Añadimos los archivos PHPMailer que vamos a usar para enviar el mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if ($errorInputMail) {//Si el email, el asunto o el cuerpo del mail están vacíos se lo indico al usuario
    header("Location: ./index.php?emailInput=0");
} else if (!filter_var($email["gmail"], FILTER_VALIDATE_EMAIL)) {//Si el email no es válido
    header("Location: ./index.php?email=0");
} else {//Si Tienen contenido y el correo electrónico es correcto envío el email
    //Enviamos el correo
    //Añadimos los archivos PHPMailer que necesitamos para enviar el mail
    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/autoload.php';

//Creamos la instancia de PHP mailer
    $mail = new PHPMailer();
    try {//Intentamos enviar el correo
        //Introducimos los parámetros del servidor: vamos a usar servidor gmail
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Permitimos que en caso de algún error con el servidor de gmail nos devuelva la información de dicho error (Esto en producción deberá ser 0)
        $mail->isSMTP(); //Le indicamos que vamos a trabajar con un servidor SMTP que es el que usa gmail
        $mail->Host = 'smtp.gmail.com'; //Introducimos el host de email
        $mail->Port = 465; //puerto SSL que utiliza gmail
        $mail->SMTPAuth = true; //Activamos la autentificación SMTP
        //Introducimos las credenciales de nuestra cuenta gmail desde la que vamos a mandar el correo
        $mail->Username = "ut6empresauser@gmail.com"; //email
        $mail->Password = 'ouumaoppiqnnoqzc'; //Contraseña del email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Permitimos la encriptación de la comunicación
        //Destinatario
        $mail->setFrom("ut6empresauser@gmail.com", 'User - UT6 Empresa'); //Quién envía el email
        $mail->addAddress($email["gmail"], 'Admin - UT6 Empresa'); //Receptor del email
        //$mail->addReplyTo('info@example.com', 'Information');//Si queremos añadir una dirección de respuesta
        //$mail->addCC('cc@example.com');//Si queremos añadir una copia
        //$mail->addBCC('bcc@example.com');//Si queremos añadir una copia oculta
        //Si queremos adjuntar archivos
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        //Contenido del Email
        //$mail->isHTML(true);//Si el formato es HTML
        $mail->Subject = $email["subject"]; //Asunto del email
        $mail->CharSet = "UTF-8"; //Indicamos la codificación de caracteres
        $mail->Body = $email["body"]; //Cuerpo del email
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';//Texto abreviado que aparece como previsualización del mensaje antes de abrir el mail
        //Finalmente enviamos el email
        if (!$mail->send()) {//Si no se consigue enviar lanza una excepción
            unset($mail);
            throw new Exception($mail->ErrorInfo);
        } else {//Si el email se ha enviado correctamente, en el index le indico al usuario que el email ha sido enviado:
            unset($mail);
            header("Location: ./index.php?emailSent=1");
        }
    } catch (Exception $e) {//Si no se ha podido enviar le indico al usuario el error
        unset($mail);
        header("Location: ./index.php?emailSent=0");
    }
}






    