<?php
require 'config.php';

$tcpsetting = sprintf("tcp://%s:%s", POP_SERVER, POP_PORT);

$fp = fsockopen($tcpsetting, POP_PORT, $err, $errno, 10);

$r = fgets($fp, 1024);
$message = sprintf("USER %s\r\n", MAIL_USER_NAME);
fputs($fp, $message);

$r = fgets($fp, 1024);
$message2 = sprintf("PASS %s\r\n", MAIL_PASSWORD);
fputs($fp, $message2);


$r = fgets($fp, 1024);
fputs($fp, "STAT\r\n");
$r = fgets($fp, 1024);
sscanf($r, '+OK %d %d', $num, $size);
//結果表示
var_dump($num, $size);
//メールデータ取得（件数分 RETR）
$data = array();
for ($i = 1; $i <= $num; ++$i) {
    //RETR n -n番目のメッセージ取得（ヘッダ含）
    fputs($fp, 'RETR ' . $i . "\r\n");
    //+OK
    $res = fgets($fp, 512);
    $d = "";
    while ($line = fgets($fp, 512)) {
        $d .= $line;
    }
    $data[$i] = $d;
}
//結果表示
var_dump($data);
//終了
fputs($fp, "QUIT\r\n");
fgets($fp, 1024);
