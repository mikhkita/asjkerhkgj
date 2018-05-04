/**
 * Created with JetBrains PhpStorm.
 * User: anton
 * Date: 31.10.13
 * Time: 19:34
 * To change this template use File | Settings | File Templates.
 */
// ������� ��������� ����� ���� li � #menu-top
function getSummLiWidth() {
    var widthLi = 0;
    $('#menu-top li.root').each(function(index, element) {
        widthLi = widthLi + $(element).width()
    });
    return widthLi;
}
// �������� �������� �� ����
function checkWidth() {
    var ulWidth = $("#menu-top").width();
    var liWidth = getSummLiWidth();
    if (liWidth > ulWidth) {
        return true;
    }
    return false;
}

function fontSize() {
    if (checkWidth()) {

// ���, ������� ����������� fontSize
        var currentFontSize = $("#menu-top li").css("font-size").replace('px', '');
        var j=1;
        while (j<15 && checkWidth() == true && currentFontSize > 3) {
            currentFontSize = currentFontSize-1;
            $('#menu-top li').css({fontSize: currentFontSize+'px'});
            j++;
        }
    }
}
$(function() {
    // fontSize();
});

function checkImgAttrbs(){
    $("#workarea img").each(function(){
        if($.trim($(this).attr("src"))==""){
            $(this).attr("src","/local/templates/demoshop/images/nophoto.png");
        }
    });
}
setInterval(checkImgAttrbs, 500);

/*function applicationAdd(name, phone, mail, message){
    $.ajax({
        url: '/include/ajax/contacts/feedback.php',
        type: 'POST',
        dataType:'json',
        data: {
            name:name,
            phone:phone,
            mail:mail,
            message:message
        }
    })
        .done(function (result) {
        });
}
$(document).ready(function() {
    $('.feedback').submit(function (e){
        e.preventDefault();
        const name = $('input[name = "name"]').val();
        const phone = $('input[name = "phone"]').val();
        const mail = $('input[name = "mail"]').val();
        const message = $('#message').val();
        applicationAdd(name, phone, mail, message);
        $('input[name = "name"]').val("");
        $('input[name = "phone"]').val("");
        $('input[name = "mail"]').val("");
        $('#message').val('');
    });

});*/
