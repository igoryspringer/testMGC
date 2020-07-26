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

$( document ).ready(function() {

    $('#today').click(
        function(){
            $('.nav-link.active').removeClass('active');
            $('#today').addClass('active');
            sendAjaxForm('today');
            return false;
        }
    );

    $('#yesterday').click(
        function(){
            $('.nav-link.active').removeClass('active');
            $('#yesterday').addClass('active');
            sendAjaxForm("yesterday");
            return false;
        }
    );

    $('#thisweek').click(
        function(){
            $('.nav-link.active').removeClass('active');
            $('#thisweek').addClass('active');
            sendAjaxForm("week");
            return false;
        }
    );
    $('.icalendar__days div').click(
        function(){
            $('.icalendar__days div.icalendar__today').removeClass('icalendar__today');
            $(this).addClass('icalendar__today');
            let day = $(this).text();
            let month = $('#icalendarMonth').text();
            let elem = (day + ' ' + month);
            sendAjaxForm(elem);
            return false;
        }
    );
});

function sendAjaxForm(date) {
    $.ajax({
        url: '/date',
        type: 'POST',
        dataType: 'html',
        data: {'date': date},
        async: true,

        success: function(html) {
            $('#list').html(html);
        },
        error: function(response) {
            $('#list').html('Error. Data not send.');
        }
    });
}