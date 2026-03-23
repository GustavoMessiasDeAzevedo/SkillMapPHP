<?php

require_once __DIR__ . '/../Includes/PHPMailer/Exception.php';
require_once __DIR__ . '/../Includes/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../Includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService{
    public static function enviarRecuperacao ($email, $token){
        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->Port = SMTP_PORT;

            $mail->setFrom("sistema@skillmap.com", "SkillMap");
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Recuperação de Senha";
            $mail->Body = "Olá você solicitou a troca de senha, clique no link abaixo para redefini-la: <br>
                          <a href = 'http://localhost/SkillMap/view/AlterarSenha.php?token=$token'>Redefinir Agora</a>";

            $mail->send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}