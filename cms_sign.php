<?php
//2. 회원가입 join.php 스텝1 계정생성 본문
$reqdate = date("YmdHis");
$clntReqNum = $reqdate . rand(100000, 999999);
$posturlCode = "01001";
$postclntReqNum = $clntReqNum;
$postreqdate = $reqdate;
$reqInfo = $posturlCode . "/" . $postclntReqNum . "/" . $postreqdate;
$oED = new Crypt();
$certPath = "/var/www/html/vmp_cms/dream_cert/playkokCert.der";
$sEncryptedData = $oED->encrypt($reqInfo, $certPath);

if ($sEncryptedData == false) {
    echo $oED->ErrorCode;
}

/////////////////////////////본인인증확인후//////////////////////////////////
$postpriinfo = $_REQUEST["priinfo"];


if ($postpriinfo != NULL) {
    $prikey = "/var/www/html/vmp_cms/dream_cert/playkokPri.key";// 개인키와 비밀번호를 입력
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



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cms.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="../signature-pad-master/assets/flashcanvas.js"></script><![endif]-->
    <script src="../js/cms.js"></script>
    <script src="../js/sign.js"></script>
    <!--<script src="/js/html2canvas.min.js"></script>-->
    <!-- 화면 캡쳐 CDN -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="../js/jspdf.min.js"></script>


    <title>KIP Shop</title>

</head>
<body>

<div id="head" class="sub">
    <h1 style="cursor: pointer;" onclick="javascript:location.href='/';">KIP Shop</h1>
</div>
<form id="t_data">

    <div id="cont" class="cont_form">
        <div class="wrap_form_agree">
            <div class="box_agree">
                <h2>약관동의</h2>
                <div class="all_agree">
                    <input type="checkbox" id="allagree">
                    <label for="allagree">전체동의</label>
                </div>
                <ul class="list_yakwan">
                    <li>
                        <span class="box_doc">
                            <input type="checkbox" id="doc1">
                            <label for="doc1">전자상거래 이용 약관</label>
                        </span>
                        <span class="btn">전체보기</span>
                    </li>
                    <li>
                        <span class="box_doc">
                            <input type="checkbox" id="doc2">
                            <label for="doc2">개인정보 수집 및 이용 동의</label>
                        </span>
                        <span class="btn">전체보기</span>
                    </li>
                    <li>
                        <span class="box_doc">
                            <input type="checkbox" id="doc3">
                            <label for="doc3">취소 및 환불 규정</label>
                        </span>
                        <span class="btn">전체보기</span>
                    </li>
                </ul>
            </div>
            <div class="wrap_certi">
                <h2>본인인증</h2>
                <ul class="list_certi">
                    <li>
                         <span class="box_certi">
                            <label for="certi1"><span class="mark">*</span>본인인증</label>
                        </span>

                        <form name=form1 action="https://www.mobile-ok.com/popup/common/hscert.jsp"
                              method=post>
                            <input type=hidden name=req_info value='<?= $sEncryptedData ?>'>
                            <input type=hidden name=rtn_url value='http://vmp-cms.kro.kr/cms_sign.php'>
                            <input type=hidden name=cpid value='playkok'>
                            <input type="submit" value="본인인증" onclick="" class="btn btn1"/>
                            <input type="hidden" name="ji_result" id="ji_result" value=''>
                            <input type="hidden" name="ji_ci" id="ji_ci" value=''>
                            <input type="hidden" name="ji_di" id="ji_di" value=''>
                            <input type="hidden" name="ji_tel" id="ji_tel" value=''>
                            <input type="hidden" name="ji_telcom" id="ji_telcom" value=''>
                            <input type="hidden" name="ji_birth" id="ji_birth" value=''>
                            <input type="hidden" name="ji_gender" id="ji_gender" value=''>
                            <input type="hidden" name="ji_forigner" id="ji_forigner" value=''>
                            <input type="hidden" name="ji_name" id="ji_name" value=''>
                        </form>

                    </li>
                    <li>
                         <span class="box_certi">
                            <label for="certi2"><span class="mark">*</span>제휴사 아이디</label>
                            <input type="text" name="certi2" id="certi2" value="" placeholder="아이디를 입력해 주세요.">
                        </span>
                        <span class="btn btn2" onclick="sel_ck()">확인</span>
                    </li>
                    <li>
                         <span class="box_certi">
                            <label for="email"><span class="mark">*</span>E-mail</label>
                            <input type="text" id="email" name="email" value=""
                                   placeholder="CMS를 전송 전송받을 E-mail을 입력하세요.">
                        </span>
                        <span class="btn btn3" onclick="verifyEmail()">확인</span>
                    </li>
                </ul>
            </div>
            <div class="contact">
                <h2>전자계약서</h2>
                <p class="txt_contact">
                    아래 문서의 서명을 요청합니다.<br/>
                    문서 확인후 서명 가능일 이내에 서면해 주시기 바랍니다.<br/>
                    서명 후 상품 결제가 진행 됩니다.
                </p>
                <a href="#" class="btn_sign">문서 확인 후 서명하기</a>
            </div>
            <div class="box_payment">
                <a href="#" class="btn_payment dis" onclick="pay()">결제하기</a>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="inner">
            <ul class="list_yakwan">
                <li><a href="">전자상거래 이용약관</a></li>
                <li><a href="">개인정보 수집 및 이용 </a></li>
                <li><a href="">취소 및 환불 규정</a></li>
            </ul>
            <ul class="info">
                <li>(주)ㅇㅇㅇㅇ(대표이사 : 이 ㅇㅇ)</li>
                <li>주소 : 대시 송파구 송파대로 570</li>
                <li>사업자 등록번호 : 120-88-00767</li>
                <li>통신판매업신고 : 2017-서울송파-0680</li>
            </ul>
            <p class="copyright">Copyright ⓒ 2020 KIP. All Rights Reserved</p>
        </div>
    </div>
    <div id="pop_yakwan">

    </div>
    <div class="pop_area">
        <div class="wrap_pop sign1">
            <p id="txt1" class="txt1">아이디 : 123456</p>
            <p id="txt2" class="txt1">김*국</p>
            <p class="txt2">님이 맞으신가요?</p>
            <div class="btn_area">
                <span class="btn btn_yes">예</span>
                <span class="btn btn_no">아니요</span>
            </div>
        </div>
        <div class="wrap_pop sign2">
            <p>수신받을 수 없는 이메일 입니다.<br/> 이메일 주소를 확인해 주세요.</p>
            <div class="btn_area">
                <span class="btn btn_close">닫기</span>
            </div>
        </div>
        <div class="wrap_pop sign3">
            <p>이메일 확인 되었습니다.<br/> 계속 진행해 주세요.</p>
            <div class="btn_area">
                <span class="btn btn_confirm">확인</span>
            </div>
        </div>
    </div>
    <div class="pop_mask"></div>

</form>

<!--전자계약서완료본 스샷찍음됨-->
<div id="cont_main">
    <div class="head">
        CMS-pro 구매 계약서
        <i class="btn_close"><span class="blind">비주얼 선택 닫기</span></i>
    </div>
    <div id="cont_sign">
    </div>
    <img id="cont_img" height="169px">
</div>


</body>
</html>
<script src="../signature-pad-master/jquery.signaturepad.js"></script>
<script>
    setParentText();

    $(function () {

        $('#allagree').change(function () {
            if ($(this).prop('checked')) {
                $('checkbox').prop('checked', true);
            } else {
                $('checkbox').prop('checked', false);
            }
        })
    });


    function pay() {


        html2canvas(document.querySelector("#cont_main")).then(canvas => {
            if (!$('input[type=checkbox]').eq(1).is(':checked')) {
                alert("약관에 동의해주세요.");
                return;
            }
            if (!$('input[type=checkbox]').eq(2).is(':checked')) {
                alert("약관에 동의해주세요.");
                return;
            }
            if (!$('input[type=checkbox]').eq(3).is(':checked')) {
                alert("약관에 동의해주세요.");
                return;
            }
            if ($('.btn_sign').text() != '서명완료') {
                alert("계약서에 서명해주세요.");
                return;
            }

            if (!$('#certi2').attr('readonly')) {
                alert("제휴사 아이디를 인증해주세요.");
                return;
            }
            if (!$('#email').attr('readonly')) {
                alert("이메일을 확인해주세요.");
                return;
            }

            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 320;
            var pageHeight = 295;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var heightLeft = imgHeight;

            var doc = new jsPDF('p', 'mm');
            var position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            doc.save('CMS계약서');

            var html = $('#cont_main').html();
            var sign_img = $('#cont_img').attr('src');

            var data = new FormData;
            var tdata = getFormData($("#t_data"));
            for (var key in tdata) {
                data.append(key, tdata[key]);
            }
            data.append("html", html);
            data.append("sign_img", sign_img);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./ajax/pay.php");


            xhr.onload = function (e) {

                if (this.status == 200) {
                    // console.log(e.currentTarget.responseText);
                    if (e.currentTarget.responseText.trim() == '성공') {

                    } else {
                        alert('잘못된 접근입니다.')
                    }
                }
            };
            xhr.upload.onprogress = function (e) {

            };

            xhr.send(data);
        });
    }


    function setParentText() {//본인인증 완료
        if ('<?=$rtn[0]?>' == '00') {
            $('.btn1').closest('li').find('label').addClass('on');
            $('.btn1').hide();
            $("#ji_result").val('<?=$rtn[0]?>');
            $("#ji_ci").val('<?=$rtn[1]?>');
            $("#ji_di").val('<?=$rtn[2]?>');
            $("#ji_tel").val('<?=$rtn[3]?>');//핸폰번호
            $("#ji_telcom").val('<?=$rtn[4]?>');//통신사
            $("#ji_birth").val('<?=$rtn[5]?>');//생년월일
            $("#ji_gender").val('<?=$rtn[6]?>');//성별
            $("#ji_forigner").val('<?=$rtn[7]?>');//외국인
            $("#ji_name").val('<?=$rtn[8]?>');//이름
        }
    }

    function sel_ck() {//제휴사아이디확인인
        var mb_id = $('#certi2').val();
        if (mb_id == '') {
            alert("아이디를 입력해주세요.");
            return;
        }

        $.ajax({
            type: 'post',
            url: './api/sel_ck.php',
            data: {'mb_id': mb_id},
            dataType: 'json',
            error: function (xhr, status, error) {
                alert(error + xhr + status);
            },
            success: function (data) {
                // console.log(data);
                if (data.success == 'ok') {
                    $('.pop_mask, .sign1').show();
                    $('#txt1').html(data.mb_id);
                    $('#txt2').html(data.mb_name);
                } else {
                    alert('존재하지 않는 아이디입니다.')
                }

            },
        });
    }

    $(document).on('click', '.wrap_pop .btn_yes', function () {
        $('#certi2').prop('readonly', true);
        $('.btn2').closest('li').find('label').addClass('on');
        $('.pop_mask, .sign1').hide();
        $('.btn2').hide();
    });
    $(document).on('click', '.wrap_pop .btn_no', function () {
        $('.pop_mask, .sign1').hide();
    });


    function verifyEmail() {
        // 이메일 검증 스크립트 작성
        var emailVal = $("#email").val();

        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
        // 검증에 사용할 정규식 변수 regExp에 저장

        if (emailVal.match(regExp) != null) {
            $('.btn3').closest('li').find('label').addClass('on');
            $('.btn3').hide();
            $("#email").prop('readonly', true);
            $('.pop_mask, .sign3').show();
        } else {
            alert('잘못된 이메일입니다.');
        }
    };

    $(document).on('click', '.btn_sign', function (e) {
        e.preventDefault();
        $('.pop_mask').show()
        $('#pop_yakwan').load('/cms_pop2.php .pop_cms', function () {
            $(document).ready(function () {
                $('.sigPad').signaturePad({drawOnly: true});
            });
            $('#save_sign').click(function () {
                e.preventDefault();

                $('.sigPad').submit();
            })
        })

    });

    function sign_success() {
        if ($('.error').html() != '서명을 해주세요.') {
            var canvas = document.getElementById('canvas');
            var canvasValue = canvas.toDataURL();
            $('#cont_img').attr('src', canvasValue);
            $('#cont_sign').html($('.cont').html());
            $('#pop_yakwan').empty();
            $('.pop_mask').hide();
            $('.btn_sign').addClass('complete').text('서명완료');
            $('.btn_payment').removeClass('dis');
        }
        return false;
    }


</script>
