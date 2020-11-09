<?php

include_once "/include/dbConn.php";


$email = "lilyosia@gmail.com";
$subject = "안녕하세요";
$message = "ㅎㅇㅎㅇ";

$path = "/var/www/html/";

//첨부 파일 읽기

/*$filename = basename($userfile_name[$i]);  // 파일명만 추출 후 $filename에 저장
$fp = fopen($userfile[$i], "r");     // 파일 open
$file = fread($fp, $userfile_size[$i]);  // 파일 내용을 읽음
fclose($fp);           // 파일 close*/

$filename = "/var/www/html/vmp_cms/storage/constract/1604898396_홍동우.pdf";

$mail_file = "1604898396_홍동우.pdf";

$fp = fopen('/var/www/html/vmp_cms/storage/constract/1604898396_홍동우.pdf', "r") or die("파일열기에 실패하였습니다");;
$file = fread($fp, filesize($filename));

/*echo $file;
print_r($_FILES);*/

fclose($fp);

$to = "lilyosia@gmail.com"; //!!!TEST CODE
$subject = "=?utf-8?b?".base64_encode($subject)."?=";

$boundary = "----" . uniqid("part"); //적당히 unique하게 만들어주면 됨



$header =
    "From: $email\r\nX-Sender: $email\r\n".
    "MIME-Version: 1.0\r\n".
    "Content-Type: Multipart/mixed; boundary=\"$boundary\""; //1

$body =
    "This is a multi-part message in MIME format.\r\n\r\n".
    "--$boundary\r\n".
    "Content-Type: text/html; charset=UTF-8\r\n".
    "Content-Transfer-Encoding: 8bit\r\n\r\n".
    $message."\r\n".
    "--$boundary\r\n"; //2

$body =
    "Content-Type: application/octet-stream; name=\"".$mail_file."\"\r\n".
    "Content-Transfer-Encoding: base64\r\n".
    "Content-Disposition: attachment; filename=\"".$mail_file."\"\r\n\r\n".
    base64_encode($file)."\r\n\r\n".
    "--$boundary--"; //3

//mail($to, $subject, $body, $header);


?>


