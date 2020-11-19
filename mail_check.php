<?php

/* =======================================================================    눈이오면의 메일 체크 함수
SnowCheckMail ($Email,$Debug=false) $Email : 체크하기 위한 메일 주소 $Debug : 디버깅을 위한 변수, true로 하면 각 과정의 진행상황이 출력된다.
* 함수명을 바꾸시지 않고 사용하시면 누구나 사용하실수 있습니다.
 * 참고 : O'REILLY - Internet Email Programming ========================================================================= */
function SnowCheckMail($Email, $Debug = true)
{
    global $HTTP_HOST;
    $Return = array();   // 반환용 변수
// $Return[0] : [true|false] - 처리결과의 true,false 값을 저장.
// $Return[1] : 처리결과에 대한 메세지 저장.

    if (!preg_match("/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i", $Email)) {
        $Return[0] = false;
        $Return[1] = "{$Email}은(는) 올바르지않은 메일 형식입니다.";
        if ($Debug)
            echo "에러 : {$Email}은 올바르지 않은 메일 형식입니다.<br>";
        return $Return;
    } else if ($Debug)
        echo "확인 : {$Email}은 올바른 메일 형식입니다.<br>"; // 메일은 @를 기준으로 2개로 나눠줍니다.
// 만약에 $Email 이 "lsm@ebeecomm.com"이라면
// $Username : lsm
// $Domain : ebeecomm.com 이 저장
// list 함수 레퍼런스 : http://www.php.net/manual/en/function.list.php
// split 함수 레퍼런스 : http://www.php.net/manual/en/function.split.php

    list ($Username, $Domain) = preg_match("@", $Email); // 도메인에 MX(mail exchanger) 레코드가 존재하는지를 체크. 근데 영어가 맞나 모르겠네여 -_-+
    if(!$Domain){
        $Email = explode("@",$Email);
        $Domain = $Email[1];
    }
// checkdnsrr 함수 레퍼런스 : http://www.php.net/manual/en/function.checkdnsrr.php
    if (checkdnsrr($Domain, "MX")) {
        if ($Debug) echo "확인 : {$Domain}에 대한 MX 레코드가 존재합니다.<br>"; // 만약에 MX 레코드가 존재한다면 MX 레코드 주소를 구해옵니다.
// // getmxrr 함수 레퍼런스 : http://www.php.net/manual/en/function.getmxrr.php
        if (getmxrr($Domain, $MXHost)) {
            if ($Debug) {
                echo "확인 : MX LOOKUP으로 주소 확인중입니다.<br>";
                for ($i = 0, $j = 1; $i < count($MXHost); $i++, $j++) {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;결과($j) - $MXHost[$i]<BR>";
                }
            }
        } // getmxrr 함수는 $Domain에 대한 MX 레코드 주소를 $MXHost에 배열형태로 저장시킵니다.
// // $ConnectAddress는 소켓접속을 하기위한 주소입니다.
        $ConnectAddress = $MXHost[0];
    } else { // MX 레코드가 없다면 그냥 @ 다음의 주소로 소켓접속을 합니다.
        $ConnectAddress = $Domain;
        if ($Debug) echo "확인 : {$Domain}에 대한 MX 레코드가 존재하지 않습니다.<br>";
    } // $ConnectAddress에 메일 포트인 25번으로 소켓 접속을 합니다. // fsockopen 함수 레퍼런스 : http://www.php.net/manual/en/function.fsockopen.php
    $Connect = fsockopen ( $ConnectAddress, 25 ); //echo "Connect : $Connect <br>"; // 소켓 접속에 성공
    if ($Connect) {
        if ($Debug) echo "{$ConnectAddress}의 SMTP에 접속 성공했습니다.<br>"; // 접속후 문자열을 얻어와 220으로 시작해야 서비스가 준비중인 것이라 판단. // 220이 나올때까지 대기 처리를 하면 더 좋겠지요 ^^; // fgets 함수 레퍼런스 : http://www.php.net/manual/en/function.fgets.php
        if (preg_match("^220", $Out = fgets($Connect, 1024))) { // 접속한 서버에게 클라이언트의 도착을 알립니다.
            fputs($Connect, "HELO $HTTP_HOST\r\n");
            if ($Debug) echo "실행 : HELO $HTTP_HOST<br>";
            $Out = fgets($Connect, 1024); // 서버의 응답코드를 받아옵니다. //
            echo $Out . "////////////////////////////"; // 서버에 송신자의 주소를 알려줍니다. //
            fputs($Connect, "MAIL FROM: LEJGDGVCJVTLBXFGGME ");
            fputs($Connect, "MAIL FROM: asdf@asd.asd");
            if ($Debug) echo "실행 : MAIL FROM: asdf@asd.asd ";
            $From = fgets($Connect, 1024); // 서버의 응답코드를 받아옵니다. //
            echo $From . "/////////////////////////"; // 서버에 수신자의 주소를 알려줍니다.
            fputs($Connect, "RCPT TO: <{$Email}>\r\n");
            if ($Debug) echo "실행 : RCPT TO: &lt;{$Email}&gt;<br>";
            $To = fgets($Connect, 1024); // 서버의 응답코드를 받아옵니다. // 세션을 끝내고 접속을 끝냅니다.
            fputs($Connect, "QUIT\r\n");
            if ($Debug) echo "실행 : QUIT<br>";
            fclose($Connect); // MAIL과 TO 명령에 대한 서버의 응답코드가 답긴 문자열을 체크합니다. // 명령어가 성공적으로 수행되지 않았다면 몬가 문제가 있는 것이겠지요. // 수신자의 주소에 대해서 서버는 자신의 메일 계정에 우편함이 있는지를 // 체크해 없다면 550 코드로 반응을 합니다.
            if (!preg_match("^250", $From) || !preg_match("^250", $To)) {
                $Return[0] = false;
                $Return[1] = "{$Email}은(는) 메일서버에서 허가되지 않은 주소입니다.";
                if ($Debug) {
                    echo "{$ConnectAddress}에서 허가하지 않는 메일주소입니다.<br>";
                } //
                echo $From . "////////////<br>//////////" . $To;
                return $Return;
            }
        }
    } // 소켓 접속에 실패
    else if (!$Connect) {
        $Return[0] = false;
        $Return[1] = "메일서버({$ConnectAddress})에 접속할 수 없습니다.";
        if ($Debug) echo "{$ConnectAddress}의 SMTP에 접속 실패했습니다.<br>";
        return $Return;
    } // 오~ 위를 모두 통과한 메일에 대해서는 맞는 메일이라고 생각하고 눈 딱 감아주져.^^;
    $Return[0] = true;
    $Return[1] = "{$Email}은(는) 아무런 문제가 없는 메일주소입니다.";
    return $Return;
} //
$return = SnowCheckMail("dsflksdf@naver.com"); //$return[0]의 값이 1이면 실재 존재하는 맬주소 //$return[0]의 값이 1이 아니면 잘못된주소이거나 맬 서버가 죽었거나..ㅠㅠ //도움이 되셨으면 함니다..저두 도움을 받아서리...^^
//이 방법에서 주의하실 점이 있습니다. 실제로 사용되는 것을 살펴보면 신비로 같은 곳은 등록된 메일주소가 아니면 550 user unknown에러 코드를 바로 내보냅니다(텔넷에서 확인해보세요). 그런 경우는 푸하하님의 팁이 옳게 적용됩니다. 그러나 오르지오 같은 곳은(아마 대부분 메일서버가) 등록된 메일주소인지를 바로 확인하지 않습니다. RFC2821 문서에도 분명히 명시되어있듯이 RCPT TO에 대한 답변방식은 두가지가 있습니다. 원칙은 메일서버에서 받는 메일의 주소를 바로 확인하여 답변코드를 돌려주어야 하지만, 실제로는 등록된 이메일 주소를 확인해보는 시간을 절약하기 위하여 일단은 250 OK코드를 돌려줍니다. 전체메일을 보내다 보면 메일 주소가 없다는 답신 메일이 올때가 있습니다. 이것이 바로 두번째 방법으로써, 메일 주소를 나중에 확인하고 없으면, 답신 메일을 보낸 메일로 보내주는 것입니다. 이럴 경우는 푸하하님의 팁은 별로 효과적이지 못합니다. 왜냐하면 즉각적으로 550 에러 코드를 돌려주지 않기 때문입니다. 자세한 것은 RFC2821문서를 참조하세요.

print_r($return);



?>



