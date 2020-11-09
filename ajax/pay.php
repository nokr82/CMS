<?php
/************************************************************************************
 ********************************만든이 : 홍동우 ****************************************
 *******************************만든시기 : 2020/03/18 **********************************
 ******************************내용: 카드추가 ajax      **********************************
 ************************************************************************************/


require_once "tcpdf/tcpdf_import.php";
include_once('../include/dbConn.php');
include_once('../mailer.lib.php');
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set("display_errors", 1);
if ($_POST['email'] == '') {
    echo "실패";
    return;
}

if ($_POST['certi2'] == '') {
    echo "실패";
    return;
}

if ($_POST['ji_name'] == '') {
    echo "실패";
    return;
}


$img_name = time() . "_" . $_POST['ji_name'];
$data = $_POST['sign_img'];
list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);
$data = base64_decode($data);
file_put_contents('/var/www/html/vmp_cms/storage/sign_img/' . $img_name . '.png', $data);


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetFont('cid0kr');


$pdf->AddPage();

$pdf->writeHTMLCell(0, 0, "", "", $_POST['html'], 0, 1, 0, true, "", true);

$pdf->Image("/var/www/html/vmp_cms/storage/sign_img/" . $img_name . '.png', 0, 100, 0, 0, 'PNG', 'C', '', false, 300, '', false, false, 0, 0, false, false);

$pdf->Output("/var/www/html/vmp_cms/storage/constract/" . $img_name . '.pdf', "F");

$path = $img_name . '.pdf';
$sql = "INSERT INTO `cert_list` (`mb_ci`, `mb_di`, `mb_telcom`, `mb_forigen`, `email`
, `mb_birth`, `vmp_id`, `cont_path`, `mb_gender`, `in_user`) 
VALUES ('{$_POST['ji_ci']}', '{$_POST['ji_di']}', '{$_POST['ji_telcom']}', '{$_POST['ji_forigner']}', '{$_POST['email']}'
, '{$_POST['ji_birth']}', '{$_POST['certi2']}', '{$path}', '{$_POST['ji_gender']}', '{$_POST['ji_name']}');";

$pdo->query($sql);


$src = 'CMS_Pro.gg';

mailer("홍동우", "nokr82@naver.com", "nokr82@naver.com", $_POST['ji_name'] . '님 ' . "CMS 쇼필몰 구매이메일 입니다. 확장자 gg를 zip로 바꾼다음에 풀어주세요!!.", "CMS 소스입니다.", 1, $path, $src);

echo "성공";

?>



