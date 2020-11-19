<?php
$page_title = 'CMS SHOP-구매완료';
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/head.php";
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/header.php";
?>
<div id="cont" class="cont_form order_complete">
    <div class="wrap_order_complete">
        <span class="btn_down_contact">계약서 다운로드</span>
        <p class="txt1">주문이 <strong>완료</strong>되었습니다.</p>
        <p class="txt2">24시간 내에 CMS-Pro 압축파일을 E-mail로 전송 해 드립니다.</p>
        
        <div class="wrap_tbl">
            <div class="info">
                <dl>
                    <dt>받는 사람 정보</dt>
                    <dd>
                        <table>
                            <caption>받는사람 정보로 받는사람 성함과 배송 주소를 안내합니다.</caption>
                            <tbody>
                                <tr>
                                    <th scope="row">받는사람</th>
                                    <td>구매자</td>
                                </tr>
                                <tr>
                                    <th scope="row">배송 주소</th>
                                    <td>kilo20k@gmail.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </dd>
                </dl>
                <dl>
                    <dt>결제 정보</dt>
                    <dd>
                        <table>
                            <caption>결제 정보로 주문금액과 총 결제금액을 안내합니다.</caption>
                                <tbody>
                                <tr>
                                    <th scope="row">주문금액</th>
                                    <td>1,020,000원</td>
                                </tr>
                                <tr class="price_info">
                                    <th scope="row">총 결제금액</th>
                                    <td>1,020,000원</td>
                                </tr>
                            </tbody>
                        </table>
                    </dd>
                </dl>
            </div>
            <a href="" class="btn_confirm">확인</a>
        </div>
    </div>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] ."/include/footer.php";
?>