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

    $('.icalendar .icalendar__days div').click(
        function(){
            $('.icalendar .icalendar__days div.icalendar__today').removeClass('icalendar__today');
            $(this).addClass('icalendar__today');
            let day = $(this).text();
            let month = $('#icalendarMonth').text();
            let elem = (day + ' ' + month);
            //alert(elem);
            sendAjaxForm(elem);
            return false;
        }
    );

    $('#btn-del').click(
        function(){
            if(confirm('Delete?')) {
                let delelem = $('input[name=delete]:checked').val();
                let curdate = $('#current_date').text();
                sendAjaxDelete(delelem, curdate);
                return false;
            }
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

function sendAjaxDelete(delelem, curdate) {
    $.ajax({
        url: "/del",
        type: 'POST',
        dataType: 'html',
        data: {'delete': delelem, 'date': curdate},
        async: true,

        success: function(html) {
            $('#list').html(html);
        },
        error: function(response) {
            $('#list').html('Error. Data not send.');
        }
    });
}