<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $name;
    public $email;
    public $token;
    
    public function __construct($name, $email, $token) {

        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function sendConfirmation() {

        // Crear el objeto de Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('admin@appsalon.com');
        $mail->addAddress('admin@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "</strong> Tu Cuenta ha sido Creada, debes confirmarla presionando el enlace abajo</p>";
        $content .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/verify-account?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $content .= "<p>Si tu no solicitaste esta cuenta, ignora este mensaje.</p>";
        $content .= '</html>';
        
        $mail->Body = $content;

        // Enviar el Mail
        $mail->send();
    }

    public function sendInstructions() {

        // Crear el objeto de Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('admin@appsalon.com');
        $mail->addAddress('admin@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu Password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "</strong> Has solicitado reestablecer tu Password, sigue el enlace </p>";
        $content .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/reset-password?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $content .= "<p>Si tu no solicitaste esta cambio, ignora este mensaje.</p>";
        $content .= '</html>';
        
        $mail->Body = $content;

        // Enviar el Mail
        $mail->send();
    }
}