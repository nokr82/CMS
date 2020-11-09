<?php



//VMM사용
$url = 'http://vmp.company/api/cms_check.php'; //접속할 url 입력
$data['mb_id'] = $_POST['mb_id'];
$result = post_api($url,$data);

print_r($result);

function post_api($url,$data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return  $response;
}

?>
