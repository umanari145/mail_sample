<?php

require 'vendor/autoload.php';
require 'config.php';

$pop3 = new Net_POP3();

$pop3->connect(POP_SERVER);
$pop3->login(MAIL_USER_NAME, MAIL_PASSWORD, true);

$numMsg = $pop3->numMsg();


if ($numMsg > 0) {
    for ($i=1; $i <= $numMsg; $i++) {
        $decoder = new Mail_mimeDecode($pop3->getMsg($i));
        $mailData = $decoder->decode([
          'include_bodies' => true,
          'decode_bodies' => true,
          'decode_headers' => true
        ]);
        var_dump($mailData);
        exit;
        echo $mailData->headers["from"] ."\n";
        echo $mailData->body ."\n";
    }
}
