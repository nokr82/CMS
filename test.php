<?php
//2. 회원가입 join.php 스텝1 계정생성 본문
$reqdate = date("YmdHis");
$clntReqNum = $reqdate . rand(100000, 999999);
$posturlCode = "01001";
$postclntReqNum = $clntReqNum;
$postreqdate = $reqdate;
$reqInfo = $posturlCode . "/" . $postclntReqNum . "/" . $postreqdate;
$oED = new Crypt();
$certPath = "/var/www/html/gvmp/cms/dream_cert/playkokCert.der";
$sEncryptedData = $oED->encrypt($reqInfo, $certPath);

if ($sEncryptedData == false) {
    echo $oED->ErrorCode;
}


/////////////////////////////본인인증확인후//////////////////////////////////
$postpriinfo = $_REQUEST["priinfo"];


if ($postpriinfo != NULL) {
    $prikey = "/var/www/html/gvmp/cms/dream_cert/playkokPri.key";// 개인키와 비밀번호를 입력
    $keyPasswd = "vmffpdlzhr0318";
    $oED = new Crypt();
    $sDevelopedData = $oED->Decrypt($postpriinfo, $prikey, $keyPasswd);

    if ($sDevelopedData == false) {
        echo "Error : xxxPri.key 경로 및 keyPasswd가 정확한지 확인하세요.";
    } else {
        $rtn = explode("$", iconv("euc-kr", "utf-8", $sDevelopedData));
    }
}//정상적인 경우를 제외하고 priinfo 값이 없습니다.

$result = $_REQUEST["result"];
$resultCd = $_REQUEST["resultCd"];

print_r($rtn);
?>


<form name=form1 action="https://www.mobile-ok.com/popup/common/hscert.jsp"
      method=post>
    <input type=hidden name=req_info value='<?= $sEncryptedData ?>'>
    <input type=hidden name=rtn_url value='http://gvmp.company/cms/test.php'>
    <input type=hidden name=cpid value='playkok'>
    <input type="submit" value="본인인증" onclick="" class="api_submit disblock bg_blackgray color_white"/>
</form>
<input type="hidden" id="ji_email" value=''>
<input type="hidden" id="ji_result" value=''>
<input type="hidden" id="ji_ci" value=''>
<input type="hidden" id="ji_di" value=''>
<input type="hidden" id="ji_tel" value=''>
<input type="hidden" id="ji_telcom" value=''>
<input type="hidden" id="ji_birth" value=''>
<input type="hidden" id="ji_gender" value=''>
<input type="hidden" id="ji_forigner" value=''>
<input type="hidden" id="ji_name" value=''>
<input type="hidden" id="ji_cnt" value=''>

<script type="text/javascript">
    setParentText();

    function setParentText() {
        if ('<?=$rtn[0]?>' == '00') {
            // opener.document.getElementById("join_next_step").setAttribute("class", 'able')
        }
        opener.document.getElementById("ji_result").value = '<?=$rtn[0]?>';
        opener.document.getElementById("ji_ci").value = '<?=$rtn[1]?>';
        opener.document.getElementById("ji_di").value = '<?=$rtn[2]?>';
        opener.document.getElementById("ji_tel").value = '<?=$rtn[3]?>';
        opener.document.getElementById("ji_telcom").value = '<?=$rtn[4]?>';
        opener.document.getElementById("ji_birth").value = '<?=$rtn[5]?>';
        opener.document.getElementById("ji_gender").value = '<?=$rtn[6]?>';
        opener.document.getElementById("ji_forigner").value = '<?=$rtn[7]?>';
        opener.document.getElementById("ji_name").value = '<?=$rtn[8]?>';
        opener.document.getElementById("ji_cnt").value = '<?=$member_cnt['cnt']?>';

        self.close();
    }
</script>
