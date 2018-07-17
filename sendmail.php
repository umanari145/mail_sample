<?php
mb_internal_encoding("UTF-8");

require_once __DIR__ . "/vendor/autoload.php";
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;

$loader = new \Twig_Loader_Filesystem(__DIR__ .'/template');
$twig = new Twig_Environment($loader);

try {
    $mail = new PHPMailer(true);
    //charset iso2022jp使用時
    //$mail->CharSet = "ISO-2022-JP";
    //$mail->Encoding = "7bit";
    $mail->CharSet = "UTF-8";
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
    $data = [
      'name' => 'Yamada Tarou'
    ];
    $body = $twig->render('sample.txt', $data);
    $mail->isHTML(false);
    $mail->FromName = mb_encode_mimeheader("サンプルメール", "ISO-2022-JP", "UTF-8");
    $mail->Subject = mb_encode_mimeheader($subject, "ISO-2022-JP", "UTF-8");
    //iso2022jp使用時
    //$mail->Body = mb_convert_encoding($body, "ISO-2022-JP", "UTF-8");
    //utf8使用時
    $mail->Body = $body;

    $mail->send();
    echo 'mail send success!';
} catch (Exception $e) {
    echo 'mail send failed!' . $mail->ErrorInfo;
}
