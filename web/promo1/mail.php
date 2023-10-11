<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

$mail->CharSet = "UTF-8";
//$mail->Encoding = "16bit";

// если POST не пустой
if (!empty($_POST)) {
    // и если не пустые - имя, e-mail и текст сообщения
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["textArrea"])) {
        // записываем данные которые пришли от клиента из формы
        $name = $_POST["name"];
        $email = $_POST["email"];
        $textMess = $_POST["textArrea"];

        // указываем получателя сообщения
        $to = "info@myarredo.ru";

        // указываем тему письма - Subject
        $subject = "Сообщение из сайта myarredo.com (Лендинг)";

        // формируем html сообщение
        $message = <<<HTML
            <p>Сообщение из сайта myarredo.com (Лендинг)</p>
            <p>Имя: $name</p>
            <p>Email: $email</p>
            <p>Текст сообщения: $textMess</p>
HTML;

        try {
            // Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = 'smtp-pulse.com';                             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = 'myarredo@mail.ru';                       // SMTP username
            $mail->Password = 'ZYfKZWr29eB3';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                          // TCP port to connect to

            // Recipients
            $mail->setFrom('info@myarredo.ru', 'myarredo');
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;

            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "empty";
    }
}
