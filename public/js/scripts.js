/*$(document).ready(function(){
    $('div').scrollspy({target: ".rectangle_5", offset: 50});
});*/

/* AJAX form */
/*$( document ).ready(function() {
    $("#btn-form").click(
        function(){
            sendAjaxForm('result_form', 'form', '/main');
            return false;
        }
    );
});

function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#" + ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').html('');
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('Error. Data not send.');
        }
    });
}*/
