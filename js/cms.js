
$(document).on('click', '.wrap_form_agree .list_yakwan .btn', function(){
 $('.pop_mask').show()
 $('#pop_yakwan').load('../cms_pop.php .pop_cms')
});

$(document).on('click', '.pop_cms .btn_close', function() {
    $('#pop_yakwan').empty();
    $('.pop_mask').hide()
});

$(document).on('click', '.list_certi .btn1', function() {
    $(this).closest('li').find('label').addClass('on');
    $(this).hide();
});
$(document).on('click', '.site_name', function(){
    window.location.href='/index.php';
});




function getFormData($form) {//폼데이터 json 형식배열로 바꾸기
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}



$(document).on('click', '.wrap_pop .btn_close', function() {
    $('.pop_mask, .sign2').hide();
});

$(document).on('click', '.wrap_pop .btn_confirm', function() {
    $('.pop_mask, .sign3').hide();
});



$(document).on('click', '.all_agree input, .all_agree label', function(e) {
    if ( $('.all_agree input:checkbox').is(":checked")) {
        $('.list_yakwan input:checkbox').prop("checked", true);
    } else {
        $('.list_yakwan input:checkbox').prop("checked", false);
    }
});
