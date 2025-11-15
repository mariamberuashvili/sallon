<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $baseUrl = $_ENV['APP_URL'];

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong>, has creado tu cuenta en App Salón. Solo debes confirmarla presionando el siguiente enlace:</p>";
        $contenido .= "<p><a href='" . $baseUrl . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tú no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        try {
            $mail->send();
        } catch (\Exception $e) {
            error_log("Error enviando correo de confirmación: " . $mail->ErrorInfo);
        }
    }

    public function enviarInstrucciones()
    {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu password';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $baseUrl = $_ENV['APP_URL'];

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre .  "</strong>, has solicitado reestablecer tu password. Presiona el enlace para hacerlo:</p>";
        $contenido .= "<p><a href='" . $baseUrl . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tú no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        try {
            $mail->send();
        } catch (\Exception $e) {
            error_log("Error enviando correo de recuperación: " . $mail->ErrorInfo);
        }
    }
}
