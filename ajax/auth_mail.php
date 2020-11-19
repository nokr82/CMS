<?php
include_once $_SERVER['DOCUMENT_ROOT']."/include/dbConn.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/mailer.lib.php';


//데이터가 넘어오면 이메일을 먼저 넘겨준다. 메일 인증 코드 발송코드에 대해 DB에 담아둔다.

$email = $_POST['email'];

//난수 발생
$auth_number = rand(0,4444);

echo $auth_number;

if(!$email){
    $resulte['msg'] = "이메일 주소가 잘못되었습니다.";

    return;
}

$insert_sql = "insert into mail_check set 
                email = '$email',
                auth_number = '$auth_number'
               ";




if($pdo->query($insert_sql)){
    $resulte['msg'] = "T";
}else{
    $resulte['msg'] = "F";
}