<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;

try {
    $mail = new PHPMailer(true);
    $mail->CharSet = "iso-2022-jp";
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = SMTP_SERVER;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_USER_NAME;
    $mail->Password = MAIL_PASSWORD;
    $mail->SMTPSecure = 'CRAM-MD5';
    $mail->Port = MAIL_PORT;
    $mail->From = FROM_ADDRESS;

    $mail->addAddress('umanari145@gmail.com');
    //$mail->addCC();
    //$mail->addBCC();

    $subject = '【ご連絡】ご挨拶メールを送らせていただいております。';
    $body = <<< EOF
本日は晴天なり

EOF;

    $mail->isHTML(false);
    $mail->FromName = mb_encode_mimeheader("サンプルメール", "ISO-2022-JP", "UTF-8");
    $mail->Subject = mb_encode_mimeheader($subject, "ISO-2022-JP", "UTF-8");
    $mail->Body = mb_convert_encoding($body, "ISO-2022-JP", "UTF-8");

    $mail->send();
    echo 'mail send success!';
} catch (Exception $e) {
    echo 'mail send failed!' . $mail->ErrorInfo;
}
