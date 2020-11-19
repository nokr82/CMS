<?php
//grep -r  'qsca02' /var/log/maillog
//
header("Content-Type: application/json");
$email = $_POST['email'];
//$email = "lilyosia@mgail.com";


//테스트 메일 발송

//메일 보내기 test
//header("Content-type: application/json; charset=utf-8");

$nameFrom = "관리자"; //발신자
$mailFrom = "admin@kip-shop.kr"; //발신주소
$nameTo = "ㅇㅇㅇ"; //수신자
$mailTo = "$email"; //수신주소
/*$cc = "참조"; //참조
$bcc = "숨은참조"; //숨은잠조*/
$subject = "테스트"; //제목
$content = "테스트"; //내용
$charset = "UTF-8";
$nameFrom = "=?$charset?B?" . base64_encode($nameFrom) . "?=";
$nameTo = "=?$charset?B?" . base64_encode($nameTo) . "?=";
$subject = "=?$charset?B?" . base64_encode($subject) . "?=";
$header = "Content-Type: text/html; charset=utf-8\r\n";
$header.= "MIME-Version: 1.0\r\n";
$header.= "Return-Path: <" . $mailFrom . ">\r\n";
$header.= "From: " . $nameFrom . " <" . $mailFrom . ">\r\n";
$header.= "Reply-To: <" . $mailFrom . ">\r\n";

/*if ($cc) $header.= "Cc: " . $cc . "\r\n";
if ($bcc) $header.= "Bcc: " . $bcc . "\r\n";*/

//$result = mail($mailTo, $subject, $content, $header, $mailFrom);
mail($mailTo, $subject, $content, $header, $mailFrom);
/*if (!$result) {
    $result = array('rst_code'=>'false', 'rst_msg'=>'전송실패');
} else {
    $result = array('rst_code'=>'false', 'rst_msg'=>'전송성공');
}

// echo json_encode($result); //
echo json_encode($result, JSON_UNESCAPED_UNICODE);*/

sleep(3);
exec("grep -r '".$email."' /var/log/maillog | tail -1",$output,$return_var);


foreach($output as $value){
    //echo "결과값 -> ".$value."<br>";
}
$check_value = $value;


if(strpos($check_value, "OK") !== false) {
    //echo "포함되어 있습니다만...";
    $result['msg'] = "T";
} else {
    $result['msg'] = "F";
}

echo json_encode($result);


