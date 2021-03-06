<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/PHPMailer/PHPMailerAutoload.php');

// 네이버 메일 전송
// 메일 -> 환경설정 -> POP3/IMAP 설정 -> POP3/SMTP & IMAP/SMTP 중에 IMAP/SMTP 사용

// 메일 보내기 (파일 여러개 첨부 가능)
// mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용", "type",계약서,소스);
// type : text=0, html=1, text+html=2

function mailer($fname, $fmail, $to, $subject, $content, $type=0,$cont='',$src='', $file="", $cc="", $bcc="")
{
    if ($type != 1)
        $content = nl2br($content);

    $mail = new PHPMailer(); // defaults to using php "mail()"

    $mail->IsSMTP();
//    $mail->SMTPDebug = 2;
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.naver.com";
    $mail->Port = 465;
    $mail->Username = "nokr82@naver.com";
    $mail->Password = "zx1411510";

    $mail->CharSet = 'UTF-8';
    $mail->From = $fmail;
    $mail->FromName = $fname;
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->AltBody = ""; // optional, comment out and test
    $mail->msgHTML($content);
    $mail->addAddress($to);
    if ($cc)
        $mail->addCC($cc);
    if ($bcc)
        $mail->addBCC($bcc);
    if ($cont != ''){
        $mail->addAttachment('/var/www/html/vmp_cms/storage/constract/'.$cont);
    }
    if ($src != ''){
        $mail->addAttachment('/var/www/html/vmp_cms/storage/'.$src);
    }

    if ( $mail->send() ){
        return $mail->send();
    } else{
        echo "실패";
    }

}

// 파일을 첨부하는 경우 사용
function attach_file($filename, $tmp_name)
{
    // 서버에 업로드 되는 파일은 확장자를 주지 않는다. (보안 취약점)
    $dest_file = '경로지정/tmp/'.str_replace('/', '_', $tmp_name);
    move_uploaded_file($tmp_name, $dest_file);
    $tmpfile = array("name" => $filename, "path" => $dest_file);
    return $tmpfile;
}

?>
