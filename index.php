<?php
$page_title = 'CMS SHOP';
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/head.php";
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/header.php";
?>
<div id="cont_main">
    <div class="main_vis">
        <p class="main_vis_txt"><img src="./images/bnr_vis_txt.png" alt="쇼핑몰? CMS Pro로 손쉽게 만드세요! CMS Pro는 최적화된 반응형 쇼핑몰 Source Code입니다."/></p>
    </div>
    <div class="wrap_product">
        <h2>CMS Pro 시리즈</h2>
        <ul class="list_product">
            <li>
                <a href="./cms_detail.php">
                    <h3>CMS Pro-1</h3>
                    <span class="badge_best"><span class="blind">Best</span></span>
                    <img src="./images/img_product1.png" alt="CMS Pro-1 이미지" />
                    <div class="product_cont">
                        <div class="pro_name">CMS Pro-1</div>
                        <div class="pro_price">1,500,000<span class="krwon_txt">원</span></div>
                        <div class="pro_intro">반응형 쇼핑몰 전용 소스코드 <br/>메인화면, 상품배열 화면, 로그인화면, 결제화면, 구매평, 문의, 마이페이지, 관리자페이지</div>
                    </div>
                </a>
            </li>
            <li>
                <h3>CMS Pro-2</h3>
                <span class="badge2"><span class="blind">출시예정</span></span>
                <img src="./images/img_product2.png" alt="CMS Pro-2 이미지" />
                <div class="product_cont">
                    <div class="pro_name">CMS Pro-2</div>
                    <div class="pro_price">1,500,000<span class="krwon_txt">원</span></div>
                    <div class="pro_intro">반응형 쇼핑몰 전용 소스코드 <br/>메인화면, 상품배열 화면, 로그인화면, 결제화면, 구매평, 문의, 마이페이지, 관리자페이지</div>
                </div>
            </li>
            <li class="warning">              
                <h3>취소 및 환불 불가</h3>
                <div class="warning_message">CMS Pro 소스코드는 <strong>복제 및 수정</strong>이 가능한 상품으로 구매 후 메일 전송이 완료 된 시점 부터 취소 및 환불이 불가능합니다.</div>
                <img src="./images/img_product3.png" alt="환불 불가 경고 이미지" />
            </li>
            <li class="cscenter">              
                <h3 class="blind">고객센터</h3>
                <div class="working">
                    <div class="tit">안내문의</div>
                        <div class="hour_txt">평일  10 : 00 ~ 16 : 00<br/>( 점심   12 : 00 ~ 13 : 00 )</div>
                        <div class="center_nbr">1588-1955</div>
                </div>
            </li>
        </ul>
    </div>
</div>
<script>
    $('#head').removeClass('sub'); // index 페이지만 header에 그라데이션이 없음
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/footer.php";
?>