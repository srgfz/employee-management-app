<?php

//Muestro los mensajes relacionados con el envío del email
if (isset($emailSent) && $emailSent) {//Si se ha enviado el mail
    echo "<p class='ps-5 text-info'> * Email enviado correctamente</p>";
} else if (isset($emailSent) && !$emailSent) {//Si no se ha podido enviar el mail
    echo "<p class='ps-5 text-danger'> * El Email no se ha podido envíar</p>";
} else if (isset($emailInput) && !$emailInput) {
    echo "<p class='ps-5 text-danger'> * Debe completar todos los campos para enviar el Email</p>";
} else if (isset($email) && !$email) {
    echo "<p class='ps-5 text-danger'> * La dirección de correo electrónico introducida no es válida</p>";
}
//Muestro el formulario del email
emailForm();
